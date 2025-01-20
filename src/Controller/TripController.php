<?php

namespace App\Controller;

use App\Repository\TripRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TripController extends AbstractController
{
    /**
     * Route permettant d'afficher l'ensemble de Trips
     */
    #[Route('/trips', name: 'app_trips', methods: ['GET'])]
    public function index(TripRepository $tr): Response
    {
        return $this->render('trip/index.html.twig', [
            'trips' => $tr->findBy(
                [], // Critère de recherche
                ['id' => 'ASC'], // Ordre de tri
                10, // Nombre de trips à récupérer
            ), // Récupérer 10 trips
            'title' => 'Trips',
            'description' => 'Les trips disponibles sur la plateforme. 100% made by you!',
        ]);
    }
    
    /**
     * Route permettant l'accès à l'affichage d'un Trip seul
     */
    #[Route('/trip/{ref}', name: 'app_trip', methods: ['GET'])]
    public function show(TripRepository $tr, string $ref): Response
    {
        $trip= $tr->findOneBy(['ref' => $ref]); // Récupérer 1 trip
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
            'title' => $trip->getTitle(),
            'description' => $trip->getDescription() ?? $trip->getTitle(),
        ]);
    }
}
