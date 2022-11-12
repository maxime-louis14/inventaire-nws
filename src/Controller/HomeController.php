<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\service\MailerService;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        $enfants = $reservationRepository->findBy(array('isrenderd' => false));

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'enfants' => $enfants
        ]);
    }

    #[Route('/emailRappel/{id}', name: 'app_emailrelance', methods: ["POST"])]

    public function mail(MailerService $mailService, Reservation $reservation)
    {
        $destinaire = $reservation->getEmail();
        $messageSubject = "Mail de relance";
        $materiel = $reservation->getProduct()->getName();
        $loandate = $reservation->getLoandate()->format('d-m-Y H:i:s');
        $rendered = $reservation->getRendered()->format('d-m-Y H:i:s');
        $messageBody = "
        <h1>Mail de relance matériel</h1>
        <p>
        A la date a la quelle vous avez emprunté : $loandate  <br/>
        Vous avez emprunté le matériel  : $materiel <br/>
        La date à rendre :  $rendered    <br/>
        </p>
        ";
        $mailService->sendMailer($destinaire, $messageSubject, $messageBody);
        //    return new Response('oui' , Response::HTTP_OK);
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
