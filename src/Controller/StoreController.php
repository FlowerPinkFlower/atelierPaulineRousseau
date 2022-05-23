<?php

namespace App\Controller;


// use App\Entity\Product;
use App\Entity\Category;
// use App\Entity\SubCategory;
// use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoreController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('store/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('store/contact.html.twig');
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
    public function savoirfaire(): Response
    {
        return $this->render('store/savoirfaire.html.twig');
    }

    /**
     * @Route("/", name="home")
     */
    public function indexByCategory(CategoryRepository $categoryRepo): Response
    {

        return $this->render('base.html.twig', [
            'categorie'=>$categoryRepo->findAll(),
            // 'subCategory'=>$subCategoryRepo->findAll(),
            // 'product'=>$product->findAll(),
        ]);
    }


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
    public function conseils(): Response
    {
        return $this->render('store/conseils.html.twig');
    }

}
