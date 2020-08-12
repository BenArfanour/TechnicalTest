<?php

namespace App\Controller;

use App\Manager\ClubManager;
use App\Manager\PlayerManager;
use App\Repository\ClubRepository;
use App\Repository\PlayerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    protected $clubManager ;
    protected $playerManager ;
    protected $clubRepository ;
    protected $playerRepository;

    // injection de dépendances ici
    public function __construct(ClubManager $clubManager,PlayerManager $playerManager,ClubRepository $clubRepository,PlayerRepository $playerRepository)
    {
        $this->clubManager = $clubManager;
        $this->playerManager = $playerManager;
        $this->clubRepository = $clubRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * This function allow us to access to The dashbord
     * @Route("/",name="home_page")
     *
     */
    public function home(Request $request,PaginatorInterface $paginator) {

        $clubs = $paginator->paginate(
            $this->clubManager->getListClub(), // Requête contenant les données à paginer (ici nos clubs)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('home/home.html.twig', [
            'clubs' => $clubs ,
        ]);
    }

    /**
     * This function allow us to get to players by club
     * @Route("/players/{id}",name="palyer_by_club")
     *
     */
    public function playersByClub(Request $request,PaginatorInterface $paginator,$id) {

        $players = $paginator->paginate(
            $this->playerManager->getPlayersByClub($id), // Requête contenant les données à paginer (ici nos clubs)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('players/players.html.twig', [
            'players' => $players ,
            'club' => $this->clubRepository->find($id),
        ]);
    }

    /**
     * This function allow us to get to players by club
     * @Route("/players/season/{id}",name="club_season_by_player")
     *
     */
    public function clubsAndSeansonsByPlayer(Request $request,PaginatorInterface $paginator,$id) {

        $clubs = $paginator->paginate(
            $this->playerManager->getClubsAndSeansonByPlayer($id), // Requête contenant les données à paginer (ici nos clubs)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('club/club.html.twig', [
            'clubs' => $clubs ,
            'fullname' => $this->playerRepository->find($id),
        ]);
    }
}