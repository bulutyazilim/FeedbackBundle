<?php

namespace BulutYazilim\FeedbackBundle\Controller;

use BulutYazilim\FeedbackBundle\Entity\Feedback;
use BulutYazilim\FeedbackBundle\Form\Type\FeedbackType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FeedbackController extends Controller
{
    public function newAction(Request $request)
    {
        $translator = $this->get('translator');
        $em = $this->getDoctrine()->getManager();
        $feedback = new Feedback();
        $form = $this->createForm(FeedbackType::class, $feedback, [
            'categories' => $this->getParameter('feedback_categories')
        ]);
        $form->handleRequest($request);

        if($form->isValid()){
            $feedback
                ->setReferer($request->headers->get('referer'))
                ->setSenderIp($request->getClientIp())
                ->setLoggedUser($this->getUser() ? $this->getUser()->getId() : null)
                ->setStatus(Feedback::STATUS_NONE)
                ->setCreated(new \DateTime())
                ->setUpdated(new \DateTime())
                ->setDeleted(false)
            ;
            $em->persist($feedback);
            $em->flush();

            if($this->container->hasParameter('feedback_email')
                && $this->container->hasParameter('system_email')
                && $this->container->hasParameter('project_name')){
                $message = $this->get('mailer')->createMessage();
                $message = $message
                    ->setSubject($translator->trans('new.feedback'))
                    ->addFrom($this->getParameter('system_email'), $this->getParameter('project_name'))
                    ->setTo($this->getParameter('feedback_email'), $this->getParameter('project_name'))
                    ->setBody($feedback->getBody(), 'text/html');

                $this->get('mailer')->send($message);
            }

            return JsonResponse::create([
                'status' => true
            ]);
        }

        return JsonResponse::create([
            'error' => true,
            'errors' => $form->getErrorsAsString(),
        ], 500);
    }
}
