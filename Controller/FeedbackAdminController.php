<?php

namespace He8us\FeedbackBundle\Controller;

use Doctrine\ORM\EntityManager;
use He8us\FeedbackBundle\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeedbackAdminController extends Controller
{
    /**
     * @param int $status
     *
     * @return Response
     */
    public function indexAction(int $status = 0): Response
    {
        if ($status < 0 || $status > 2) {
            $status = 0;
        }
        $data = [];
        $repo = $this->getDoctrine()->getManager()->getRepository(Feedback::class);
        $entities = $repo->findBy(['status' => $status, 'deleted' => false]);
        $data['status'] = $status;
        $data['entities'] = $entities;
        $categories = $this->container->getParameter('feedback_categories');
        $data['categories'] = $categories;
        return $this->render("He8usFeedbackBundle:FeedbackAdmin:index.html.twig", $data);
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

        $feedback->setDeleted(true);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($feedback);
        $entityManager->flush();

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
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException("Not found!");
        }

        $entityManager = $this->getEntityManager();
        $feedback = $entityManager->find(Feedback::class, $id);

        if (!$feedback) {
            throw new NotFoundHttpException("Not found!");
        }

        return $feedback;
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager(): EntityManager
    {
        return $this->getDoctrine()->getManager();
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

        $entityManager = $this->getEntityManager();
        $feedback->setStatus($this->getStatus($type));

        $entityManager->persist($feedback);

        $entityManager->flush();

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
    }
}
