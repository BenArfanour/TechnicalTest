<?php

namespace App\Manager;
use App\Repository\ClubRepository;
use App\Repository\PlayerRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PlayerManager
{

    protected $playerRepository;

    protected $clubRepository;

    public function __construct(PlayerRepository $playerRepository,ClubRepository $clubRepository)
    {
        $this->playerRepository = $playerRepository;
        $this->clubRepository = $clubRepository;
    }

    public function getPlayersByClub($id)
    {
        $club = $this->clubRepository->find($id);
        // check on club
        if (!$club) {
            throw  new NotFoundResourceException('Club Not found');
        }
        return $club->getPlayers() ;
    }


    public function getClubsAndSeansonByPlayer($id)
    {
        $player = $this->playerRepository->find($id);

        // check on player
        if (!$player) {
            throw  new NotFoundResourceException('player Not found');
        }
        return $player->getClubs() ;
    }


}