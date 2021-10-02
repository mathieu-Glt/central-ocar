<?php

namespace App\Controller;

use App\Entity\Publication;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/annonces/{id}", name="publication_show", requirements={"id"="\d+"})
     */
    public function index(Publication $publication): Response
    {   
        //dd($publication);
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }
}
