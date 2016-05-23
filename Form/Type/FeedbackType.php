<?php

namespace BulutYazilim\FeedbackBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Gregwar\CaptchaBundle\Type\CaptchaType;

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
                'choices' => $options['categories'],
                'label' => false,
                'attr' => [
                    'class' => 'form-control input-sm',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'feedback.email',
                    'class' => 'form-control',
                ],
            ])
            ->add('body', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'feedback.message',
                    'class' => 'form-control',
                ],
            ])
            ->add('screenshot', null, [
                'attr' => [
                    'class' => 'screen-uri hidden'
                ]
            ])
            ->add('captcha', CaptchaType::class, [
                'reload' => true,
                'as_url' => true,
                'attr' => [
                    'placeholder' => 'Captcha'
                ]
            ])
            ->add('submit', 'submit', [
                'attr' => [
                    'class' => 'btn btn-primary btn-block',
                ]
            ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BulutYazilim\FeedbackBundle\Entity\Feedback',
                'cascade_validation' => true,
                'categories' => [],
                'attr' => [
                    'class' => 'form-validate',
                ],
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bulutyazilim_feedbackbundle_feedback';
    }
}