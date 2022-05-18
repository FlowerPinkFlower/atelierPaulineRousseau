<?php

namespace App\Controller;

use App\Form\ProdType;
use App\Entity\Picture;
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
    
    //CREER MODIFIER PRODUIT AJOUT IMAGE
    /**
     * @Route("/product/new", name="new_prod")
     * @Route("/product/update/{id}", name="update_prod")
     */
    public function addOrUpdateProduct(Product $product=NULL, Request $request, EntityManagerInterface $em){
        if(!$product){
            $product=new Product();
        }
        $formProd=$this->createForm(ProdType::class, $product); //création du formulaire
        $formProd->handleRequest($request);
        
        if ($formProd->isSubmitted() && $formProd->isValid()) { 
            //On récupère les images transmises
            $images=$formProd->get('picture')->getData();
            //On boucle sur les images
            foreach($images as $image){
                //On génère un nouveau nom de fichier
                $fichier = md5(uniqid()). '.'.$image->guessExtension();
                //On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'), $fichier
                );
                //on stock image dans la BDD (son nom)
                //A chaque fois que l'on fait une nouvelle image (si on en met une ou pls)
                //A chaque fois que l'on va passer dnas le foreach, on va créer une nouvelle instance avec une nouvelle image
                //On va l'ajouter à produit et une fois qu'il y a le persist de $product il va en cascade faire un persist dans image pour stocker les images
                $img = new Picture();
                $img->setName($fichier);
                $product->addPicture($img);
            }
            // $em=$this->getDoctrine()->getEntityManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('prod');
        }
        return $this->render('product/productForm.html.twig', [
            'product'=>$product,
            'formProd'=>$formProd->createView(),
            'mode'=>$product->getId() !==null,
        ]);
    }

    //SUPPRIMER PRODUIT
    /**
     * @Route("/product/delete/{id}", name="delete_prod")
     */
    public function deleteProduct(Product $product, EntityManagerInterface $em){
        if ($image) {
            
        }

        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('prod');
    }

    //SUPPRIMER IMAGE
    /**
     * @Route("/product/delete/picture/{id}", name="delete_img", methods={"DELETE"})
     */    
    public function deletePicture(Picture $pitcures, Request $request){
        $data = json_decde($request->getContent(), true);
        
        //On vérifie que le token est valide
            if ($this->isCsrfTokenValid('delete'.$pictures->getId(), $data['_token'])) {
                //On récupère le nom de l'image
                $nom=$pictures->getName();
                //On supprime le fichier
                unlink($this->getParameter('images_directory').'/'.$nom);
                //On supprime de la BDD
                $em->remove($pictures);
                $em->flush();
                //On répond en Json
                return new JsonResponse(['success'=>1]);
            }else{
                return new JsonResponse(['error'=>'Token invalide'], 400);
            }
    }

}
