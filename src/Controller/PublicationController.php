<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{   
    /**
     * @Route("/annonces", name="publication_list")
     */
    public function list(PublicationRepository $publicationRepository): Response
    {   

        $publications = $publicationRepository->findAll();
        //dd($publication);
        return $this->render('list.html.twig', [
            'publications' => $publications,
        ]);
    }

    
    
    
    
    
    
    
    
    
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

    /**
     * @Route("/annonces/add", name="publication_add")
     */

    public function add(Request $request): Response
    {   
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            //isSold
            $publication->setIsSold(false);
            //PublishedAt
            $publication->setPublishedAt(new DateTimeImmutable());
            
            $user = $this->getUser();
            $publication->setUser($user);
            $em->persist($publication);
            $em->flush();
            $this->addFlash('success', 'Annonce publié');
            return $this->redirectToRoute('home_index');

        }

        return $this->render('publication/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/annonces/edit/{id}", name="publication_edit", requirements={"id"="\d+"})
     */

    public function edit(Publication $publication, Request $request): Response
    {   
        $form = $this->createForm(PublicationType::class, $publication);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            //isSold
            $publication->setIsSold(false);
            $em->flush();
            $this->addFlash('success', 'Annonce modifiée');
            return $this->redirectToRoute('home_index');

        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'form'=>$form->createView()
        ]);
    }


}
