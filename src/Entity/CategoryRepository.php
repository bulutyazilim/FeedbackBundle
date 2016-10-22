<?php
/**
 * This file is part of the he8us/feedback package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace He8us\FeedbackBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class CategoryRepository
 *
 * @package He8us\FeedbackBundle\Entity
 * @author Cedric Michaux <cedric@he8us.be>
 */
class CategoryRepository extends EntityRepository
{

    /**
     * @return Category[]
     */
    public function findAllNotDeleted()
    {
        $queryBuilder = $this->createQueryBuilder('c');

        $queryBuilder
            ->where('c.deleted = false');

        return $queryBuilder->getQuery()->getResult();
    }
}
