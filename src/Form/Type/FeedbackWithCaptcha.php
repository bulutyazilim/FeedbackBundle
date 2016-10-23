<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace He8us\FeedbackBundle\Form\Type;


use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\FormBuilderInterface;

class FeedbackWithCaptcha extends FeedbackType
{

    /**
     * @param FormBuilderInterface $formBuilder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        parent::buildForm($formBuilder, $options);


        $formBuilder->add('captcha', CaptchaType::class, [
            'reload' => true,
            'as_url' => true,
            'attr'   => [
                'placeholder' => 'Captcha',
            ],
        ]);
    }


    /**
     * @return string
     */
    public function getName()
    {
        return 'he8us_feedbackbundle_feedbackcaptcha';
    }

}
