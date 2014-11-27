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

    public function threadAction($threadId)
    {
        return $this->render('OkulbilisimFeedbackBundle:Feedback:thread.html.twig', array('threadId' => $threadId));
    }

    public function newAction(Request $request)
    {
        $email = $request->get('email');
        $body = $request->get('body');
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
            ->setCreated(new \DateTime())
            ->setUpdated(new \DateTime())
            ->setDeleted(false)
        ;
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $em->persist($feedback);
        $em->flush();
        return JsonResponse::create(['status'=>true]);
    }
}
