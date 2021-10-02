<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(PublicationRepository $publicationRepository): Response
    {   
        $mostRecentPublications = $publicationRepository->findBy([],['publishedAt'=> 'DESC'], 3);
        //dd($mostRecentPublications);

        return $this->render(
            'home/index.html.twig', 
            [
            'most_recent_publications' => $mostRecentPublications,
            ]
        );
    }
}
