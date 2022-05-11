<?php

namespace App\Controller;

use App\Entity\Description;
use App\Form\DescriptionType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DescriptionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DescriptionController extends AbstractController
{
    /**
     * @Route("/description", name="description")
     */
    public function index(DescriptionRepository $descriptionRepo): Response
    {
        $description=$descriptionRepo->findAll();
        return $this->render('description/index.html.twig', [
            'descriptions' => $description,
        ]);
    }

    
    
    //CREER MODIFIER DESCRIPTION
    /**
     * @Route("/description/new", name="new_description")
     * @Route("/description/update/{id}", name="update_description")
     */
    public function addOrUpdateDescription(Description $description=NULL, Request $request, EntityManagerInterface $em){
        if(!$description){

            $description=new Description;
        }

        $formDescription=$this->createForm(DescriptionType::class, $description); //création du formulaire
        $formDescription->handleRequest($request);
        
        if ($formDescription->isSubmitted() && $formDescription->isValid()) { 
            $em->persist($description);
            $em->flush();
            return $this->redirectToRoute('description');
        }
        return $this->render('description/descriptionForm.html.twig', [
            'formDescription'=>$formDescription->createView(),
            'mode'=>$description->getId() !==null,
        ]);
    }


    //SUPPRIMER DESCRIPTION
    /**
     * @Route("/description/delete/{id}", name="delete_description")
     */
    public function deleteDescription(Description $description, EntityManagerInterface $em){
        $em->remove($description);
        $em->flush();
        return $this->redirectToRoute('description');
    }
}
