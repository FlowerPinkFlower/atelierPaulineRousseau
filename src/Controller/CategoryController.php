<?php

namespace App\Controller;

use App\Form\CateType;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CategoryController extends AbstractController
{
    //AFFICHER TOUTES LES CATEGORIES
    /**
     * @Route("/category", name="cate")
     */
    public function showAllCategories(CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        try{
            $this->denyAccessUnlessGranted('ROLE_ADMIN'); //Refusé l'accès sauf si c'est l'administrateur
            $categories = $cateRepo->findAll(); 
            return $this->render('category/index.html.twig', [
                'categories' => $categories,
                'cate'=>$cateRepo->findAll(),
                'SubCate'=>$subCateRepo->findAll(),
            ]);
        }
        catch(AccessDeniedException $ex){  //Si l'accès est refusé alors redirigé la personne vers la page d'accueil
            return $this->redirectToRoute('home'); 
        }
    }

     //AJOUTER/MODIFIER CATEGORIE
    /**
     * @Route("/category/new", name="new_cate")
     * @Route("/category/add/{id}", name="add_cate")
     */
    public function updateOrAddCategory(Category $category=NULL, Request $request, EntityManagerInterface $em, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo){
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if (!$category) {
            $category = new Category;
        }
            $formCate=$this->createForm(CateType::class,$category); //creation du formulaire
            
            $formCate->handleRequest($request); //traiter la demande = handle request.

            if ($formCate->isSubmitted() && $formCate->isValid()) {
                $em->persist($category); //on persiste category
                $em->flush();
                
                return $this->redirectToRoute('cate');
            }
        
            return $this->render('category/categoryForm.html.twig', [
                'formCate' => $formCate->createView(), //créer la nouvelle catégorie
                'mode' => $category ->getId() !==null, //modifie la catégorie
                'cate'=>$cateRepo->findAll(),
                'SubCate'=>$subCateRepo->findAll()
            ]);
        } 
        catch (AccessDeniedException $ex) {
           return $this->redirectToRoute('home');
        }
    }


    //SUPPRIMER CATEGORIE
    /**
     * @Route("/category/delete/{id}", name="delete_cate")
     */
    public function deleteCategory(Category $category, EntityManagerInterface $em, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo):Response{
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
            $em->remove($category);
            $em->flush();
            
            return $this->redirectToRoute('cate',[
                'cate'=>$cateRepo->findAll(),
                'SubCate'=>$subCateRepo->findAll()
            ]);
        }
        catch(AccessDeniedException $ex){
            return $this->redirectToRoute('home');
        }
    }
}
