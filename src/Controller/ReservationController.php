<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Service\CallApiService;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// use Symfony\Component\Validator\Constraints\DateTime;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository, CallApiService $collApiService): Response
    {

        $reservations = $reservationRepository->findBy(array('isrenderd' => false));

        $idapi = $collApiService->getDataNws();
        $array = [];

        // Je passe dans les tableaux pour recupérer tout les données id, nom, prenom, mail.
        foreach ($idapi as $key => $value) {
            //  echo $key . '<br/>';
            if (is_array($value)) {
                foreach ($value as $key => $value) {
                    // echo '' . $key . ' ' . $value . "<br/>";
                    array_push($array, $key, $value);
                }
            }
            
        };
        // array_map applique une function au element du tableau
        $array = array_map(function ($e) {
            return [
                'id' => $e['id']
            ];
        }, $idapi);
        // dd($array);
        // le $array a bien les id de l'api
        // Je veux envoyer c'est donner en bdd
        

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);


        // Si m'ont formulaire et envoyait et valide, tu ajoutes une nouvelle date et tu enlèves une quantité à ce produit
        if ($form->isSubmitted() && $form->isValid()) {

            $reservation->setLoandate(new \DateTime());
            // Je, mais le checkbox a false pour qu'il ne soit pas valide quand une nouvelle réservation se créait
            $reservation->setIsrenderd(false);
            // Je veux incrémentation et décrémentation les stocks de produit dans l'entity matereil
            // (La manière la plus basique et naturelle est l’utilisation du ‘+1’ ou ‘-1’) -$a Négation Opposé de $a.

            // $quantity et egale a $reservation et qui recuper les donnés de product 
            // et product recuper les donnés de Quantity et fait -1 retire une quantités
            $quantity = $reservation->getProduct()->getQuantity() - 1;
            $reservation->getProduct()->setQuantity($quantity);


            $reservationRepository->add($reservation, true);
            $reservationRepository->save($reservation, true);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    // C'est la route pour voir une réservation précise par ID
    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        //Je veux comparer mon ancien isIsrenderd au nouveaux
        $oldereservation = $reservationRepository->find($reservation->getId());
        //Ceci est là parce que ce n'est pas fou 
        $oldrenderd = $oldereservation->isIsrenderd();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Je veux incrémenter et décrémenter la quantité du produits
            // Si mon produit et rendu tu me rajoure +1 a la quantité et si il n'est pas rendu tu -1
            // tU FAIT PLUS 1 QUANT LE PRODUIT ET RENDU. 
            if ($oldrenderd != $reservation->isIsrenderd()) {
                if ($reservation->isIsrenderd()) {
                    $product = $reservation->getProduct()->getQuantity() + 1;
                    $reservation->getProduct()->setQuantity($product);
                } else {
                    $quantity = $reservation->getProduct()->getQuantity() - 1;
                    $reservation->getProduct()->setQuantity($quantity);
                }
            }
            $reservationRepository->add($reservation, true);
            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
