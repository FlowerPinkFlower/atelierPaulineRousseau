<?php

namespace App\Controller;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{


     /**
     * @Route("/", name="home")
     */
    public function index(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/index.html.twig', [
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()

        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/contact.html.twig',[
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): Response
    {
        return $this->render('store/test.html.twig');
    }

    /**
     * @Route("/savoirfaire", name="savoirfaire")
     */
    public function savoirfaire(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/savoirfaire.html.twig',[
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    /**
     * @Route("/mentionLegale", name="mentionLegale")
     */
    public function mentionLegale(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/mentionLegale.html.twig',[
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    // /**
    //  * @Route("/", name="home")
    //  */
    // public function indexByCategory(CategoryRepository $categoryRepo): Response
    // {

    //     return $this->render('base.html.twig', [
    //         'categorie'=>$categoryRepo->findAll(),
    //         'subCategory'=>$subCategoryRepo->findAll(),
    //         'product'=>$product->findAll(),
    //     ]);
    // }


    // /**
    //  * @Route("/accueil", name="accueil")
    //  */
    // public function accueil(): Response
    // {
    //     return $this->render('store/accueil.html.twig');
    // }

    /**
     * @Route("/conseils", name="conseils")
     */
    public function conseils(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/conseils.html.twig',[
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    /**
     * @Route("/erreur", name="erreur")
     */
    public function erreur(SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('store/erreur.html.twig',[
        'cate'=>$cateRepo->findAll(),
        'SubCate'=>$subCateRepo->findAll()
        ]);
    }

}
