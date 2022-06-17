<?php

namespace App\Controller;

use App\Form\ProdType;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProductController extends AbstractController
{
    //AFFICHER TOUS LES PRODUITS
    /**
     * @Route("/product", name="prod")
     */
    public function showAllProducts(ProductRepository $prodRepo, SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        $products=$prodRepo->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'SubCate'=>$subCateRepo->findAll(),  
            'cate'=>$cateRepo->findAll()
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
    public function showAllNecklace(ProductRepository $prodRepo, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        $products=$prodRepo->findBy(['subCategory'=>'2']);
        return $this->render('product/indexAllNecklace.html.twig', [
            'necklace' => $products,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll(),
        ]);
    }

        
    //AFFICHAGE DESCRIPTION COLLIER ONGLET PRODUITS SHOP SELON ID
    /**
     * @Route("/product/allnecklaces/necklace/{id}", name="necklace", methods={"GET"})
     */
    public function showNeacklaces(Product $product, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        return $this->render('product/showNeacklaces.html.twig', [
            'necklace' => $product,
            'SubCate'=>$subCateRepo->findAll(),  
            'cate'=>$cateRepo->findAll()
        ]);
    }


    //AFFICHAGE BRACELETS ONGLET SOUS CATEGORIE SHOP
    /**
     * @Route("/product/allbracelets", name="all_bracelets")
     */
    public function showAllBracelets(ProductRepository $prodRepo, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        $products=$prodRepo->findBy(['subCategory'=>'3']);
        return $this->render('product/indexAllBracelets.html.twig', [
            'bracelet' => $products,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll()  
        ]);
    }
    //AFFICHAGE DESCRIPTION BRACELET ONGLET PRODUITS SHOP SELON ID

    /**
     * @Route("/product/allbracelets/bracelet/{id}", name="bracelet", methods={"GET"})
     */
    public function showBracelet(Product $product, SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        return $this->render('product/showBracelet.html.twig', [
            'bracelet' => $product,
            'SubCate'=>$subCateRepo->findAll(),  
            'cate'=>$cateRepo->findAll()
        ]);
    }



    //AFFICHAGE BOUCLES D'OREILLES ONGLET SOUS CATEGORIE SHOP
    /**
     * @Route("/product/allearings", name="all_earings")
     */
    public function showAllEarings(ProductRepository $prodRepo, SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo): Response
    {
        $products=$prodRepo->findBy(['subCategory'=>'1']);
        return $this->render('product/indexAllEarings.html.twig', [
            'earing' => $products,
            'SubCate'=>$subCateRepo->findAll(),  
            'cate'=>$cateRepo->findAll()
        ]);
    }

    //AFFICHAGE DESCRIPTION BOUCLE D'OREILLES ONGLET PRODUITS SHOP SELON ID
    /**
     * @Route("/product/allearings/earing/{id}", name="earing", methods={"GET"})
     */
    public function showEaring(Product $product, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        return $this->render('product/showEaring.html.twig', [
            'earing' => $product,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll(),
        ]);
    }


 //AJOUTER/MODIFIER PRODUIT
    /**
     * @Route("/product/new", name="new_prod")
     * @Route("/product/update/{id}", name="update_prod")
     */
    public function addOrUpdateProduct(Product $product=NULL, Request $request, EntityManagerInterface $em, SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo){
        try {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');

            if (!$product) {
                $product = new Product();
            }
            $formProd=$this->createForm(ProdType::class,$product); //creation du formulaire
            
            $formProd->handleRequest($request); //traiter la demande = handle request.
    
            if ($formProd->isSubmitted() && $formProd->isValid()) {
    
                if($product->getPhoto()){
                    $photoName=$this->getParameter('images_directory'). '/' . $product->getPhoto();
                    if(file_exists($photoName)){ //si la photo existe, elle est supprimé
                        unlink($photoName);
                    }
                }
                
                $photoProd=$formProd->get('photo')->getData(); //méthode qui permet de récupérer la donnée de la photo
    
                $photo = md5(uniqid()) . '.' . $photoProd->guessExtension(); //uniqid = basé sur le temps donc jamais un id identique
                $photoProd->move($this->getParameter('images_directory'), $photo);
    
                
                $product->setPhoto($photo);
                $em->persist($product); //on persiste produit
                $em->flush();
                
                return $this->redirectToRoute('prod');
            }
        
            return $this->render('product/productForm.html.twig', [
                'formProd' => $formProd->createView(), //créer la nouvelle catégorie
                'mode' => $product ->getId() !==null, //modifie la catégorie
                'SubCate'=>$subCateRepo->findAll(),  
                'cate'=>$cateRepo->findAll()
            ]);
        } catch (AccessDeniedException $ex) {
            return $this->redirectToRoute('home');
        }
        
    }


    //SUPPRIMER PRODUIT
    /**
     * @Route("/product/delete/{id}", name="delete_prod")
     */
    public function deleteProduct(Product $product, EntityManagerInterface $em, SubCategoryRepository $subCateRepo, CategoryRepository $cateRepo){
       try {
        $this->DenyAccessUnlessGranted('ROLE_ADMIN');
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('prod',[
            'SubCate'=>$subCateRepo->findAll(),  
            'cate'=>$cateRepo->findAll()
        ]);
       } catch (AccessDeniedException $ex) {
           return $this->redirectToRoute('home');
       }


    }
}

