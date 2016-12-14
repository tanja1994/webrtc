<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Slot;

class SlotRepository extends EntityRepository
{
    /**
     * @return Slot
     */
    public function findSlotById($slotid)
    {
        return $this->findOneBy(['id' => $slotid]);
    }

    /**
     * @return Slot
     */
    public function findALLSlotsByMeeting()
    {
        return $this->_em->createQuery('SELECT * FROM AppBundle:Slot  WHERE id = Meeting.SlotId')
            ->getResult();
    }

    public function findSlotByUser($userId)
    {
        return $this->findOneBy(['user_id' => $userId]);
    }





}
