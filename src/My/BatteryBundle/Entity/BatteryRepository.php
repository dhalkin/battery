<?php

namespace My\BatteryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * BatteryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BatteryRepository extends EntityRepository
{

    public function getStatistics(){

        $query = $this->getEntityManager()
            ->createQuery('SELECT b.type, SUM(b.count) as total_count FROM MyBatteryBundle:Battery b GROUP BY b.type');

        return $query->getResult();

    }

    public function deleteAll(){
        $query = $this->getEntityManager()
            ->createQuery('DELETE FROM MyBatteryBundle:Battery');

        return $query->execute();
    }
}