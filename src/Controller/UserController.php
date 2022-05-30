<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll()
        ]);
    }


    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // function mot de passe hash automatique
        if ($form->isSubmitted() && $form->isValid()) { 
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
                )
            );
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll()
        ]);
    }


    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository, CategoryRepository $cateRepo, SubCategoryRepository $subCateRepo): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'cate'=>$cateRepo->findAll(),
            'SubCate'=>$subCateRepo->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
