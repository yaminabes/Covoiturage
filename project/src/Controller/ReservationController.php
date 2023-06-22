<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/", name="app_reservation_index", methods={"GET"})
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        $user = $this->getUser();

        // Fetch the reservations for the current user
        $reservations = $reservationRepository->findBy(['passager' => $user]);

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * @Route("/new", name="app_reservation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReservationRepository $reservationRepository, TrajetRepository $trajetRepository): Response
    {
        $reservation = new Reservation();
        $reservation->setPassager($this->getUser());
        $id_trajet = $request->get('id_trajet');
        $trajet = $trajetRepository->find($id_trajet);
        $reservation->setTrajet($trajet);

        $reservationRepository->add($reservation, true);

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);



    }

    /**
     * @Route("/confirm_new", name="app_reservation_confirm_new", methods={"GET", "POST"})
     */
    public function confirmReservation(Request $request, ReservationRepository $reservationRepository, TrajetRepository $trajetRepository): Response
    {
        $id_trajet = $request->get('id_trajet');
        $trajet = $trajetRepository->find($id_trajet);

        return $this->renderForm('reservation/new.html.twig', [
            'trajet' => $trajet
        ]);
    }
    /**
     * @Route("/{id}", name="app_reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reservation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->add($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}