<?php

namespace Okulbilisim\FeedbackBundle\Entity;

use Doctrine\ORM\EntityRepository;

class FeedbackRepository extends EntityRepository
{

    public function findBy(array $criteria)
    {
        return parent::findBy($this->fixCriteria($criteria));
    }

    public function findOneBy(array $criteria)
    {
        return parent::findOneBy($this->fixCriteria($criteria));
    }

    public function find($id, $lockMode = \Doctrine\DBAL\LockMode::NONE, $lockVersion = null)
    {
        return $this->findOneBy(array(
                    'id' => $id
        ));
    }

    private function fixCriteria(array $criteria)
    {
        if (!in_array('deleted', $criteria)) {
            $criteria['deleted'] = false;
        }

        return $criteria;
    }

}
