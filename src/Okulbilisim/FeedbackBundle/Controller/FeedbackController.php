<?php

namespace Okulbilisim\FeedbackBundle\Controller;

use Okulbilisim\FeedbackBundle\Entity\Feedback;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FeedbackController extends Controller
{

    public function inboxAction()
    {
        return $this->render('OkulbilisimFeedbackBundle:Feedback:inbox.html.twig');
    }

    public function newAction(Request $request)
    {
        $email = $request->get('email');
        $body = $request->get('body');
        $category = $request->get('category');
        $screenshot = $request->get('screenshot') ?: null;
        $referer = $request->headers->get('referer');
        $senderIp = $request->getClientIp();
        $loggedUser = $this->getUser() ? $this->getUser()->getId() : '';

        $feedback = new Feedback();
        $feedback
            ->setBody($body)
            ->setEmail($email)
            ->setLoggedUser($loggedUser)
            ->setReferer($referer)
            ->setSenderIp($senderIp)
            ->setStatus(Feedback::STATUS_NONE)
            ->setCategory($category)
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setDeleted(false)
        ;

        if ($screenshot) {
            $feedback->setScreenshot($screenshot);
        }

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($feedback);
        $em->flush();
        return JsonResponse::create(['status'=>true]);
    }
}
