<?php

namespace OkulBilisim\FeedbackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Class WidgetController
 * @package Okulbilisim\FeedbackBundle\Controller
 */
class WidgetController extends Controller
{

    public function fixedAction()
    {

        $categories = $this->container->getParameter('feedback_categories');
        if (!$categories)
            throw new InvalidConfigurationException("The parameter 'feedback_categories' must be defined.");
        $data = [];
        $data['categories'] = $categories;
        return $this->render('OkulBilisimFeedbackBundle:Feedback:index.html.twig',$data);
    }
}