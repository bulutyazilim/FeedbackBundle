<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace He8us\FeedbackBundle\Tests\Service;

use He8us\FeedbackBundle\Entity\Feedback;
use He8us\FeedbackBundle\Entity\FeedbackRepository;
use He8us\FeedbackBundle\Service\FeedbackService;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FeedbackServiceTest
 *
 * @package He8us\FeedbackBundle\Tests\Service
 * @author Cedric Michaux <cedric@he8us.be>
 */
class FeedbackServiceTest extends ServiceTestCase
{

    /**
     * @test
     */
    public function createFeedback_WithValidParameters()
    {
        $repository = $this->mockRepository(FeedbackRepository::class);
        $entityManager = $this->mockEntityManager($repository, Feedback::class);

        $expectedFeedback = new Feedback();
        $expectedFeedback
            ->setReferrer('testReferrer')
            ->setSenderIp('127.0.0.1')
            ->setStatus(Feedback::STATUS_NONE)
            ->setBody('body');


        $entityManager->expects($this->once())
            ->method('persist')
            ->with($expectedFeedback);

        $managerRegistry = $this->mockManagerRegistry($entityManager, Feedback::class);

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getClientIp')
            ->willReturn('127.0.0.1');

        $request->headers = new HeaderBag([
            'referer' => 'testReferrer',
        ]);

        $service = new FeedbackService($managerRegistry);

        $feedback = new Feedback();
        $feedback->setBody('body');
        $service->createFeedback($feedback, $request);
    }

}
