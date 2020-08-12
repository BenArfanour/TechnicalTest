<?php

namespace App\Controller;

use App\Entity\saison;
use App\Manager\ClubManager;
use App\Manager\PlayerManager;
use App\Repository\ClubRepository;
use App\Repository\PlayerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SaisonFormType;

class HomeController extends AbstractController
{
    /******
     * Controller should call  all Managers via depandency injection to get our code more optimize
     *
     *******/


    protected $clubManager ;
    protected $playerManager ;
    protected $clubRepository ;
    protected $playerRepository;
    protected $paginatorInterface;
    protected $request;



    // injection de dépendances ici
    public function __construct(ClubManager $clubManager,PlayerManager $playerManager,ClubRepository $clubRepository,PlayerRepository $playerRepository,RequestStack $request,PaginatorInterface $paginatorInterface)
    {
        $this->clubManager = $clubManager;
        $this->playerManager = $playerManager;
        $this->clubRepository = $clubRepository;
        $this->playerRepository = $playerRepository;
        $this->request = $request->getCurrentRequest();
        $this->paginatorInterface = $paginatorInterface;
    }



    /**
     * This function allow us to access to The dashbord
     * @Route("/",name="home_page")
     *
     */
    public function home(Request $request,PaginatorInterface $paginator) {

        $saison = new saison();
        $form = $this->createForm(SaisonFormType::class, $saison);


        $clubs = $paginator->paginate(
            $this->clubManager->getListClub(), // Requête contenant les données à paginer (ici nos clubs)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );


        return $this->render('home/home.html.twig', [
            'clubs' => $clubs ,
            'form' => $form->createView(),
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


    /**
     * This function triggred only if we have ajax call
     *
     * @Route("/search/{startdate}/{enddate}",name="search_club_by_dates",methods={"POST"})
     *
     */
    public function searchSeason($startdate,$enddate)
    {
        if($this->request->isXmlHttpRequest())
            {
                $startDate = $this->request->request->get('startdate');
                $endDate = $this->request->request->get('enddate');
                $clubs = $this->clubRepository->findByDates($startDate,$endDate) ;
                dd($clubs) ;

            }
        else {
            return $this->home($this->request,$this->paginatorInterface);
        }
    }



}