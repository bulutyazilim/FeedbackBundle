<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Tests\Form\Type;


use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Form\Type\FeedbackType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class FeedbackTypeTest
 *
 * @package He8us\FeedbackBundle\Tests\Form\Type
 * @author Cedric Michaux <cedric@he8us.be>
 */
class FeedbackTypeTest extends TypeTestCase
{
    /**
     * @test
     */
    public function submit_WithValidData()
    {
        $formData = [
            'body'       => "test body",
            'screenshot' => "cksdncklsd",
            'email'      => 'me@example.com',
            'category'   => null,
        ];


        $form = $this->factory->create(FeedbackType::class);

        $feedback = $this->getFeedbackFromArray($formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($feedback, $form->getData());

        $view = $form->createView();

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $view->children);
        }
    }

    /**
     * @param array $formData
     *
     * @return Feedback
     */
    private function getFeedbackFromArray(array $formData):Feedback
    {
        $feedback = new Feedback();

        $feedback
            ->setBody($formData['body'])
            ->setScreenshot($formData['screenshot'])
            ->setCategory($formData['category'])
            ->setEmail($formData['email']);

        return $feedback;
    }

    /**
     * @test
     */
    public function submit_WithInValidData()
    {
        $formData = [
            'body'       => "test body",
            'screenshot' => "cksdncklsd",
            'email'      => 'me@example.com',
            'category'   => null,
        ];


        $form = $this->factory->create(FeedbackType::class);

        $feedback = $this->getFeedbackFromArray($formData);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($feedback, $form->getData());

        $view = $form->createView();

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $view->children);
        }
    }

}
