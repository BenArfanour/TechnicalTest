<?php

namespace App\Manager;

use App\Repository\ClubRepository;

class ClubManager
{
    protected $clubRepository;

    public function __construct(ClubRepository $clubRepository)
    {
        $this->clubRepository = $clubRepository;
    }

    public function getListClub()
    {
      return $this->clubRepository->findAll() ;
    }


}