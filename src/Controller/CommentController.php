<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/comment', name: 'comment_')]
class CommentController extends AbstractController
{
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function edit(Request $request, Comment $comment, Episode $episode, CommentRepository $commentRepository): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('program_episode_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
            'episode' => $episode,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function delete(Request $request, Comment $comment, CommentRepository $commentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $commentRepository->remove($comment, true);
        }

        return $this->redirectToRoute('program_index', [
            'program' => $comment->getEpisode()->getSeason()->getProgram()->getSlug(),
            'season' => $comment->getEpisode()->getSeason()->getNumber(),
            'episode' => $comment->getEpisode()->getSlug(),
        ], Response::HTTP_SEE_OTHER);
    }
}
