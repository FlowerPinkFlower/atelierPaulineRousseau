<?php

namespace App\Controller;

use App\Form\ProdType;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    //AFFICHER TOUS LES PRODUITS
    /**
     * @Route("/product", name="prod")
     */
    public function showAllProducts(ProductRepository $prodRepo): Response
    {
        $products=$prodRepo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    //AFFICHAGE SOUS CATEGORIE SHOP
    /**
     * @Route("/product/{id}", name="show_categorie")
     */
    // public function ShowCategorie(Product $product): Response
    // {
    //     return $this->render('category/show.html.twig', [
    //         'products' => $product,
    //     ]);
    // }




    //AFFICHAGE COLLIERS ONGLET SOUS CATEGORIE SHOP
    /**
     * @Route("/product/allnecklaces", name="all_necklaces")
     */
    public function showAllNecklace(ProductRepository $prodRepo): Response
    {
        $products=$prodRepo->findBy(['subCategory'=>'2']);
        return $this->render('product/indexAllNecklace.html.twig', [
            'necklace' => $products
        ]);
    }

        
    //AFFICHAGE COLLIERS ONGLET PRODUITS SHOP
    /**
     * @Route("/product/allnecklaces/necklace/{id}", name="necklace", methods={"GET"})
     */
    public function showNeacklaces(Product $product): Response
    {
        return $this->render('product/showNeacklaces.html.twig', [
            'necklace' => $product
        ]);
    }


    //AFFICHAGE BRACELETS ONGLET SOUS CATEGORIE SHOP
    /**
     * @Route("/product/allbracelets", name="all_bracelets")
     */
    public function showAllBracelets(ProductRepository $prodRepo): Response
    {
        $products=$prodRepo->findBy(['subCategory'=>'3']);
        return $this->render('product/indexAllBracelets.html.twig', [
            'bracelet' => $products,
        ]);
    }

    /**
     * @Route("/product/allbracelets/bracelet/{id}", name="bracelet", methods={"GET"})
     */
    public function showBracelet(Product $product): Response
    {
        return $this->render('product/showBracelet.html.twig', [
            'bracelet' => $product,
        ]);
    }



    //AFFICHAGE BOUCLES D'OREILLES ONGLET SOUS CATEGORIE SHOP
    /**
     * @Route("/product/allearings", name="all_earings")
     */
    public function showAllEarings(ProductRepository $prodRepo): Response
    {
        // $products=$prodRepo->findBy(['subCategory'=>'2']);
        $products=$prodRepo->findAll();
        return $this->render('product/indexAllEarings.html.twig', [
            'earing' => $products,
        ]);
    }

        
    //AFFICHAGE BOUCLE D'OREILLES ONGLET PRODUITS SHOP
    /**
     * @Route("/product/allearings/earing/{id}", name="earing", methods={"GET"})
     */
    public function showEaring(Product $product): Response
    {
        return $this->render('product/showEaring.html.twig', [
            'earing' => $product,
        ]);
    }


 //AJOUTER/MODIFIER PRODUIT
    /**
     * @Route("/product/new", name="new_prod")
     * @Route("/product/update/{id}", name="update_prod")
     */
    public function addOrUpdateProduct(Product $product=NULL, Request $request, EntityManagerInterface $em){
        if (!$product) {
            
            $product = new Product;
        }
            $formProd=$this->createForm(ProdType::class,$product); //creation du formulaire
            
            $formProd->handleRequest($request); //traiter la demande = handle request.

            if ($formProd->isSubmitted() && $formProd->isValid()) {
                $photoProd=$formProd->get('photo')->getData(); //méthode qui permet de récupérer la donnée de la photo

                $photoName=$this->getParameter('images_directory'). '/' . $product->getPhoto();
                if(file_exits($photoName)){ //si la photo existe, elle est supprimé
                    unlink($photoName);
                }
                
                
                $em->persist($product); //on persiste category
                $em->flush();
                
                return $this->redirectToRoute('prod');
            }
        
            return $this->render('product/productForm.html.twig', [
                'formProd' => $formProd->createView(), //créer la nouvelle catégorie
                'mode' => $product ->getId() !==null //modifie la catégorie
            ]);
        
    }



 


    //SUPPRIMER PRODUIT
    /**
     * @Route("/product/delete/{id}", name="delete_prod")
     */
    public function deleteProduct(Product $product, EntityManagerInterface $em){
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('prod');
    }
}

