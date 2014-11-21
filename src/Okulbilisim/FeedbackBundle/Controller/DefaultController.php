<?php

namespace Okulbilisim\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OkulbilisimFeedbackBundle:Default:index.html.twig');
    }
}
