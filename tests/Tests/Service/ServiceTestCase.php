<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace He8us\FeedbackBundle\Tests\Service;


use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;

class ServiceTestCase extends PHPUnit_Framework_TestCase
{

    /**
     * @param string $repository
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockRepository(string $repository):PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this
            ->getMockBuilder($repository)
            ->disableOriginalConstructor()
            ->getMock();

        return $mock;
    }


    /**
     * @param EntityRepository $repository
     * @param string           $expectedClass
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockEntityManager(
        EntityRepository $repository,
        string $expectedClass
    ):PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['getRepository', 'persist', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('getRepository')
            ->with($expectedClass)
            ->willReturn($repository);

        return $mock;
    }

    /**
     * @param EntityManager $entityManager
     *
     * @param string        $expectedClass
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockManagerRegistry(
        EntityManager $entityManager,
        string $expectedClass
    ):PHPUnit_Framework_MockObject_MockObject
    {
        $mock = $this->createMock(ManagerRegistry::class);
        $mock
            ->expects($this->atMost(2))
            ->method('getManagerForClass')
            ->with($expectedClass)
            ->willReturn($entityManager);

        return $mock;
    }

}
