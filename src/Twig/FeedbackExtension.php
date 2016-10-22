<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Twig;

use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Form\Type\FeedbackWithCaptcha;
use He8us\FeedbackBundle\Service\CategoryService;
use Symfony\Component\Form\FormFactoryInterface;
use Twig_Environment;
use Twig_SimpleFunction;

/**
 * Class FeedbackExtension
 *
 * @package He8us\FeedbackBundle\Twig
 */
class FeedbackExtension extends \Twig_Extension
{
    /**
     * @var  FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var  Twig_Environment
     */
    private $twig;

    /**
     * @var CategoryService
     */
    private $categoryService;


    /**
     * FeedbackExtension constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param Twig_Environment     $twig
     * @param CategoryService      $categoryService
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        Twig_Environment $twig,
        CategoryService $categoryService
    ) {
        $this->twig = $twig;
        $this->categoryService = $categoryService;
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
     * @return string
     */
    public function widget()
    {
        $categories = $this->categoryService->getCategories();
        $feedback = new Feedback();
        $form = $this->formFactory->create(FeedbackWithCaptcha::class, $feedback, [
            'categories' => $categories,
        ]);

        return $this->twig->render('He8usFeedbackBundle:Feedback:index.html.twig', [
            'form'       => $form->createView(),
            'categories' => $categories,
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
