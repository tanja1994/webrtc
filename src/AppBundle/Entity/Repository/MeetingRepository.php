<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Meeting;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Slot;

class MeetingRepository extends EntityRepository
{
    /**
     * @return Meeting
     */
    public function findSlotByMeetingId($MeetingId)
    {
        return $this->findOneBy(['slot_id' => $MeetingId]);
    }
    public function findMeetingByUser($userId)
    {
        return $this->findOneBy(['user_id' => $userId]);
    }





}
