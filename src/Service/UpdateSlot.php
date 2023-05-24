<?php

namespace App\Service;

use App\Entity\CourseDB;
use Doctrine\ORM\Mapping\Entity;

class UpdateSlot {

  public $courseRepo;
  public function __construct($entityManager)
  {
    $this->courseRepo = $entityManager->getRepository(CourseDB::class);
  }

  public function updateSlotCount($sub) {
    $subRepo = $this->courseRepo->findOneBy(['courceName' => $sub]);
    if($subRepo) {
      $subSlot = $subRepo->getCourceReach();
      if($subSlot != "NA") {
        $count = number_format($subSlot) - 1;
        if($count >= 0) {
          $subSlot = strval($count);
          $subRepo->setCourceReach($subSlot);
        }
        else {
          $subRepo->setCourceReach("NA");
        }
      }
    }
  }
}
