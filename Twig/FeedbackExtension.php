<?php

namespace He8us\FeedbackBundle\Twig;

use Doctrine\ORM\EntityManagerInterface;
use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Form\Type\FeedbackType;
use Symfony\Component\Form\FormFactoryInterface;
use Twig_Environment;
use Twig_SimpleFilter;
use Twig_SimpleFunction;

/**
 * Class FeedbackExtension
 *
 * @package He8us\FeedbackBundle\Twig
 */
class FeedbackExtension extends \Twig_Extension
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

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


    /**
     * FeedbackExtension constructor.
     *
     * @param FormFactoryInterface   $formFactory
     * @param Twig_Environment       $twig
     * @param EntityManagerInterface $entityManager
     * @param                        $feedbackCategories
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Twig_Environment $twig,
        EntityManagerInterface $entityManager,
        $feedbackCategories
    ) {
        $this->entityManager = $entityManager;
        $this->twig = $twig;
        $this->feedbackCategories = $feedbackCategories;
        $this->formFactory = $formFactory;
    }

    /**
     * @return Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('feedback_widget', [$this, 'widget']),
        ];
    }

    /**
     * @return Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('loggedUser', [$this, 'loggedUser']),
            new Twig_SimpleFilter("feedback_category", [$this, 'categories']),
        ];
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function loggedUser($user)
    {
        if (!is_int($user) || empty($user)) {
            return $user;
        }
        //@todo user entity ???
    }

    /**
     * @return string
     */
    public function widget()
    {
        $feedback = new Feedback();
        $form = $this->formFactory->create(FeedbackType::class, $feedback, [
            'categories' => $this->feedbackCategories,
        ]);

        return $this->twig->render('He8usFeedbackBundle:Feedback:index.html.twig', [
            'form'       => $form->createView(),
            'categories' => $this->feedbackCategories,
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
