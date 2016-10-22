<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Form\Type;

use He8us\FeedbackBundle\Entity\Category;
use He8us\FeedbackBundle\Entity\Feedback;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices'      => $options['categories'],
                'choice_label' => function ($category) {
                    /** @var Category $category */
                    return $category->getLabel();
                },
                'label'        => false,
                'attr'         => [
                    'class' => 'form-control input-sm',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'feedback.email',
                    'class'       => 'form-control',
                ],
            ])
            ->add('body', TextareaType::class, [
                'label' => false,
                'attr'  => [
                    'placeholder' => 'feedback.message',
                    'class'       => 'form-control',
                ],
            ])
            ->add('screenshot', HiddenType::class, [
                'attr' => [
                    'class' => 'screen-uri',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block',
                ],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'         => Feedback::class,
                'cascade_validation' => true,
                'categories'         => [],
                'attr'               => [
                    'class' => 'form-validate',
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'he8us_feedbackbundle_feedback';
    }
}
