<?php

namespace Okulbilisim\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeedbackController extends Controller
{

    public function indexAction()
    {
        return $this->render('OkulbilisimFeedbackBundle:Feedback:index.html.twig');
    }

    public function inboxAction()
    {
        return $this->render('OkulbilisimFeedbackBundle:Feedback:inbox.html.twig');
    }

    public function threadAction($threadId)
    {
        return $this->render('OkulbilisimFeedbackBundle:Feedback:thread.html.twig', array('threadId' => $threadId));
    }

}
