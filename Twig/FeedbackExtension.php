<?php

namespace BulutYazilim\FeedbackBundle\Twig;

use BulutYazilim\FeedbackBundle\Entity\Feedback;
use BulutYazilim\FeedbackBundle\Form\Type\FeedbackType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use \Twig_Environment;

/**
 * Class FeedbackExtension
 * @package BulutYazilim\FeedbackBundle\Twig
 */
class FeedbackExtension extends \Twig_Extension
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var  FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var  Twig_Environment
     */
    private $twig;

    /**
     * @var array
     */
    private $feedbackCategories = [];


    public function __construct(
        FormFactoryInterface $formFactory,
        Twig_Environment $twig,
        EntityManagerInterface $em,
        $feedbackCategories
    )
    {
        $this->em                   = $em;
        $this->twig                 = $twig;
        $this->feedbackCategories   = $feedbackCategories;
        $this->formFactory          = $formFactory;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('feedback_widget',[$this,'widget'])
        ];
    }
    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('loggedUser', [$this, 'loggedUser']),
            new \Twig_SimpleFilter("feedback_category",[$this,'categories'])
        ];
    }

    /**
     * @param $user
     * @return mixed
     */
    public function loggedUser($user)
    {
        if(!is_int($user) || empty($user)){
            return $user;
        }
        //@todo user entity ???
    }

    public function widget()
    {
        $feedback = new Feedback();
        $form = $this->formFactory->create(FeedbackType::class, $feedback, [
            'categories' => $this->feedbackCategories,
        ]);

        return $this->twig->render('BulutYazilimFeedbackBundle:Feedback:index.html.twig', [
            'form' => $form->createView(),
            'categories' => $this->feedbackCategories
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'feedback_extension';
    }
} 
