<?php

namespace He8us\FeedbackBundle\Controller;

use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Form\Type\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FeedbackController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function newAction(Request $request): JsonResponse
    {
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback, [
            'categories' => $this->get('he8us_feedback.category_service')->getCategories(),
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->persistFeedback($request, $feedback);
            $this->sendMail($feedback);

            return JsonResponse::create([
                'status' => true,
            ]);
        }

        return JsonResponse::create([
            'error'  => true,
            'errors' => (string) $form->getErrors(true, false),
        ], 500);
    }

    /**
     * @param Request  $request
     * @param Feedback $feedback
     */
    private function persistFeedback(Request $request, Feedback $feedback): void
    {
        $entityManager = $this->getDoctrine()->getManager();

        $feedback
            ->setReferrer($request->headers->get('referer'))
            ->setSenderIp($request->getClientIp())
            ->setStatus(Feedback::STATUS_NONE);

        $entityManager->persist($feedback);
        $entityManager->flush();
    }

    /**
     * @param Feedback $feedback
     */
    private function sendMail(Feedback $feedback): void
    {
        if (
            !$this->container->hasParameter('feedback_email')
            || !$this->container->hasParameter('system_email')
            || !$this->container->hasParameter('project_name')
        ) {
            return;
        }

        $translator = $this->get('translator');
        $message = $this->get('mailer')->createMessage();
        $message = $message
            ->setSubject($translator->trans('new.feedback'))
            ->addFrom($this->getParameter('system_email'), $this->getParameter('project_name'))
            ->setTo($this->getParameter('feedback_email'), $this->getParameter('project_name'))
            ->setBody($feedback->getBody(), 'text/html');

        $this->get('mailer')->send($message);

    }
}
