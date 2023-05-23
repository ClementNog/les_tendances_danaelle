<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Form\LikesType;
use App\Repository\LikesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/likes')]
class LikesController extends AbstractController
{
    #[Route('/', name: 'app_likes_index', methods: ['GET'])]
    public function index(LikesRepository $likesRepository): Response
    {
        return $this->render('likes/index.html.twig', [
            'likes' => $likesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_likes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LikesRepository $likesRepository): Response
    {
        $like = new Likes();
        $form = $this->createForm(LikesType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $likesRepository->save($like, true);

            return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('likes/new.html.twig', [
            'like' => $like,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_likes_show', methods: ['GET'])]
    public function show(Likes $like): Response
    {
        return $this->render('likes/show.html.twig', [
            'like' => $like,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_likes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Likes $like, LikesRepository $likesRepository): Response
    {
        $form = $this->createForm(LikesType::class, $like);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $likesRepository->save($like, true);

            return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('likes/edit.html.twig', [
            'like' => $like,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_likes_delete', methods: ['POST'])]
    public function delete(Request $request, Likes $like, LikesRepository $likesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$like->getId(), $request->request->get('_token'))) {
            $likesRepository->remove($like, true);
        }

        return $this->redirectToRoute('app_likes_index', [], Response::HTTP_SEE_OTHER);
    }
}
