<?php

namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Meeting;
use AppBundle\Entity\Studycourse;
use Doctrine\ORM\EntityRepository;

use AppBundle\Entity\Slot;

class StudyCourseRepository extends EntityRepository
{
    /**
     * @return Studycourse
     */
    public function findStudyCourseByStudyCoursename($studycourseName)
    {
        return $this->findOneBy(['studycourseName' => $studycourseName]);
    }





}
