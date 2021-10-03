<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CaController extends AbstractController
{
    /**
     * @Route("/cars", name="car")
     */
    public function index(): Response
    {
        return $this->render('car/index.html.twig', [
            'controller_name' => 'CaController',
        ]);
    }


        /**
     * @Route("/cars/add", name="car_add")
     */
    public function add( Request $request): Response
    {   
        $car = new Car();
        $form= $this->createForm(CarType::class,$car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush($car);
            $this->addFlash('success', 'Voiture ajoutée');
            return $this->redirectToRoute('home_index');
        }
        return $this->render('car/add.html.twig', [
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/cars/{id}/edit", name="car_edit", requirements={"id"="\d+"})
     */
    public function edit(Car $car, Request $request): Response
    {   
        $form= $this->createForm(CarType::class,$car);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush($car);
            $this->addFlash('success', 'Voiture modifiée');
            return $this->redirectToRoute('home_index');
        }
        return $this->render('car/edit.html.twig', [
            'form'=>$form->createView()
        ]);
    }


}
