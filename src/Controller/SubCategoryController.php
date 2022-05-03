<?php

namespace App\Controller;

use App\Form\SubCateType;
use App\Entity\SubCategory;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SubCategoryController extends AbstractController
{
    //AFFICHER TOUTES LES SOUS CATEGORIES
    /**
     * @Route("/sub/category", name="subCategory")
     */
    public function showAllSubCategoryController(SubCategoryRepository $subCateRepo): Response
    {
        $subCategory=$subCateRepo->findAll();
        return $this->render('sub_category/index.html.twig', [
            'subCate' => $subCategory,
        ]);
    }


    //AJOUT MODIFIER LES SOUS CATEGORIES
    /**
     * @Route("/sub/category/new", name="new_subCate")
     * @Route("/sub/category/update/{id}", name="update_subCate")
     */
    public function updateOrAddCategory(SubCategory $subCategory=NULL, EntityManagerInterface $em, Request $req){
        if(!$subCategory){

            $subCategory= new SubCategory;
        }

            $formsubCate=$this->createForm(SubCateType::class,$subCategory);

            $formsubCate->handleRequest($req);

                if($formsubCate->isSubmitted() && $formsubCate->isValid()){
                    $em->persist($subCategory);
                    $em->flush();

                    return $this->redirectToRoute('subCategory');
                }

        return $this->render('sub_category/subCategoryForm.html.twig', [
            'formsubCate'=>$formsubCate->createView(),
            'mode' => $subCategory ->getId() !==null
            ]);
    }

    //SUPPRIMER SOUS CATEGORIES
    /**
     * @Route("/sub/category/delete/{id}", name="delete_SubCate")
     */
    public function deleteSubCate(SubCategory $subCategory, EntityManagerInterface $em): Response{
       $em->remove($subCategory);
       $em->flush(); 
    return $this->redirectToRoute('subCategory');
    }
}
