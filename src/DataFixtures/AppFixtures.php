<?php

namespace App\DataFixtures;

use App\Entity\club;
use App\Entity\images;
use App\Entity\player;
use App\Entity\saison;
use App\Repository\ClubRepository;
use App\Repository\ImagesRepository;
use App\Repository\PlayerRepository;
use App\Repository\SaisonRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    protected $clubRepository ;
    protected $saisonRepository ;
    protected $logoRepository ;
    protected $PlayerRepository ;

    // injection de dépendances
    public function __construct(ClubRepository $clubRepository,SaisonRepository $saisonRepository,ImagesRepository $logoRepository,PlayerRepository $PlayerRepository)
    {
        $this->clubRepository = $clubRepository ;
        $this->saisonRepository = $saisonRepository ;
        $this->logoRepository = $logoRepository ;
        $this->PlayerRepository = $PlayerRepository ;
    }

    public function load(ObjectManager $manager)
    {

        // Fixture Saison 1
        for ($i=0 ; $i<9 ; $i++)
        {
            $season = new saison();
            $season->setName('Name'.$i);
            $startDate = '201'.$i.'-11-08 0'.$i.':00:00' ;
            $endDate = '201'.$i.'-11-08 0'.$i.':00:00' ;
            $season->setStartdate(new \DateTime($startDate));
            $season->setEnddate(new \DateTime($endDate));
            $manager->persist($season);
            $manager->flush();

        }

        // Fixture Saison 2
        for ($i=0 ; $i<9 ; $i++)
        {
            $season = new saison();
            $season->setName('Name'.$i);
            $startDate = '202'.$i.'-11-08 0'.$i.':00:00' ;
            $endDate = '202'.$i.'-11-08 0'.$i.':00:00' ;
            $season->setStartdate(new \DateTime($startDate));
            $season->setEnddate(new \DateTime($endDate));
            $manager->persist($season);
            $manager->flush();

        }


        //Fixture logo
        for ($i=0 ; $i<20 ; $i++)
        {
            $logo = new images();
            $logo->setUrl('https://upload.wikimedia.org/wikipedia/fr/7/70/Racing_Club_de_Strasbourg_Alsace_%28RC_Strasbourg_-_RCS_-_RCSA%29_logo_officiel.svg');
            $logo->setName('Image'.$i);
            $manager->persist($logo);
            $manager->flush();

        }



        //Fixture Club
        for ($i=0 ; $i<20 ; $i++)
        {
            $club = new club();
            $season = $this->saisonRepository->findOneBy(['name'=>'Name'.$i]);
            $logo = $this->logoRepository->findOneBy(['name'=>'Image'.$i]);
            $club->setName('Club'.$i);
            $club->setGoalnumber($i);
            //Numéro unique spécifique
            $club->setSpecifcnumber(uniqid('', true));
            $club->setImages($logo);
            $club->setSeason($season);
            $manager->persist($club);
            $manager->flush();
        }


        // Fixture Player
        for ($i=0 ; $i<20 ; $i++)
        {
            $player = new player();
            $club = $this->clubRepository->findOneBy(['name'=>'Club'.$i]);
            $player->setFirstname('Firstname'.$i);
            $player->setLastname('Lastname'.$i);
            $manager->persist($player);
            $manager->flush();
        }

        // Fixture add Players

        for ($i=0 ; $i<20 ; $i++)
        {
            $club = $this->clubRepository->findOneBy(['name'=>'Club'.$i]);
            $player = $this->PlayerRepository->findOneBy(['firstname'=>'Firstname'.$i]);
            $club->addPlayer($player);
            $manager->persist($club);
            $manager->flush();
        }

        for ($i=0 ; $i<20 ; $i++)
        {
            $club_f = $this->clubRepository->findOneBy(['name'=>'Club'.$i]);
            $player_f = $this->PlayerRepository->findOneBy(['firstname'=>'Firstname'.$i]);
            $club_f->addPlayer($player_f);
            $manager->persist($club_f);
            $manager->flush();

        }



        // Fixture add Clubs
        for ($i=0 ; $i<20 ; $i++)
        {
            $club_first = $this->clubRepository->findOneBy(['name'=>'Club'.$i]);
            $player_first = $this->PlayerRepository->findOneBy(['firstname'=>'Firstname'.$i]);
            $player->addClub($club_first);
            $manager->persist($player_first);
            $manager->flush();

        }
        for ($i=0 ; $i<20 ; $i++)
        {
            $club_second = $this->clubRepository->findOneBy(['name'=>'Club'.$i]);
            $player_second = $this->PlayerRepository->findOneBy(['firstname'=>'Firstname'.$i]);
            $player_second->addClub($club_second);
            $manager->persist($player_second);
            $manager->flush();

        }









    }
}
