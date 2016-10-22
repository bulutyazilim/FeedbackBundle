<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Service;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;


/**
 * Class AbstractService
 *
 * @package He8us\FeedbackBundle\Service
 * @author Cedric Michaux <cedric@he8us.be>
 */
abstract class AbstractService
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;


    protected $entityClass;

    /**
     * CategoryService constructor.
     *
     * @param ManagerRegistry $managerRegistry
     *
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository():EntityRepository
    {
        return $this->getManager()->getRepository($this->entityClass);
    }

    /**
     * @return ObjectManager|null
     */
    protected function getManager()
    {
        return $this->managerRegistry->getManagerForClass($this->entityClass);
    }
}
