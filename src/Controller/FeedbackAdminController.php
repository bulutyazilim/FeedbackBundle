<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Controller;

use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Service\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class FeedbackAdminController
 *
 * @package He8us\FeedbackBundle\Controller
 * @author Cedric Michaux <cedric@he8us.be>
 */
class FeedbackAdminController extends Controller
{
    /**
     * @param string $status
     *
     * @return Response
     */
    public function indexAction(string $status): Response
    {
        if ($status !== Feedback::STATUS_DONE && $status !== Feedback::STATUS_READ) {
            $status = Feedback::STATUS_NONE;
        }

        return $this->render("He8usFeedbackBundle:FeedbackAdmin:index.html.twig", [
            'status'    => $status,
            'feedbacks' => $this->getFeedbackService()->findByStatus($status),
        ]);
    }

    /**
     * @return FeedbackService
     */
    private function getFeedbackService():FeedbackService
    {
        return $this->get('he8us_feedback.feedback_service');
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $id): JsonResponse
    {
        $feedback = $this->getFeedback($request, $id);

        $this->getFeedbackService()->delete($feedback);

        return JsonResponse::create(['status' => true]);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return Feedback
     */
    private function getFeedback(Request $request, $id): Feedback
    {
        $this->validateRequest($request);

        $feedback = $this->getFeedbackService()->findById($id);

        $this->validateFeedback($feedback);

        return $feedback;
    }

    /**
     * @param Request $request
     *
     * @throws NotFoundHttpException
     */
    private function validateRequest(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException("Not found!");
        }
    }

    /**
     * @param $feedback
     *
     * @throws NotFoundHttpException
     */
    private function validateFeedback(Feedback $feedback = null)
    {
        if (!$feedback) {
            throw new NotFoundHttpException("Not found!");
        }
    }

    /**
     * @param Request $request
     * @param         $id
     * @param string  $type
     *
     * @return JsonResponse
     */
    public function markAsAction(Request $request, $id, string $type = "read"): JsonResponse
    {
        $feedback = $this->getFeedback($request, $id);

        $feedback->setStatus($this->getStatus($type));

        $this->getFeedbackService()->save($feedback);

        return JsonResponse::create(['status' => true]);
    }

    /**
     * @param $type
     *
     * @return int
     */
    private function getStatus(string $type)
    {
        if ($type == 'read') {
            return Feedback::STATUS_READ;
        }

        if ($type == 'done') {
            return Feedback::STATUS_DONE;
        }

        return Feedback::STATUS_NONE;
    }

    /**
     * @param Request  $request
     * @param Feedback $id
     *
     * @return Response
     */
    public function replyAction(Request $request, Feedback $id): Response
    {
        $data = [];
        $data['message'] = $id;
        $data['toemail'] = $this->container->getParameter('system_email');

        if ($request->isMethod('POST')) {
            $this->sendMessage($request, $id);
        }
        return $this->render('He8usFeedbackBundle:FeedbackAdmin:reply.html.twig', $data);
    }

    /**
     * @param Request  $request
     * @param Feedback $feedback
     */
    public function sendMessage(Request $request, Feedback $feedback): void
    {
        $form = $request->get('message');
        $mailer = $this->container->get('mailer');
        $message = $mailer->createMessage()
            ->setSubject($form['subject'])
            ->setFrom($this->container->getParameter('system_email'))
            ->setTo($feedback->getEmail())
            ->setBody(
                $this->container->get('twig')->render($this->container->getParameter('feedback_reply_mail_layout'),
                    ['form' => $form, 'feedback' => $feedback])
            )
            ->setContentType('text/html');
        $mailer->send($message);

        /** @var Session $session */
        $session = $this->container->get('session');
        $session->getFlashBag()->add('success', $this->get('translator')->trans("Message send successfully."));

        return true;
    }
}
