<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Comment;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\CommentType;
use App\Form\ProgramType;
use App\Form\SearchProgramType;
use Symfony\Component\Mime\Email;
use App\Repository\CommentRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack, Request $request): Response
    {
        $programs = $programRepository->findAll();
        $session = $requestStack->getSession();

        if (!$session->has('total')) {
            $session->set('total', 0); // if total doesn’t exist in session, it is initialized.
        }

        $total = $session->get('total'); // get actual value in session with ‘total' key.
        // ...
        $form = $this->createForm(SearchProgramType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $programs = $programRepository->findLikeName($search);
        } else {
            $programs = $programRepository->findAll();
        }

        return $this->render(
            'program/index.html.twig',
            [
                'programs' => $programs,
                'form' => $form,
            ]
        );
    }

    #[Route('/new', name: 'new')]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function new(Request $request, MailerInterface $mailer, ProgramRepository $programRepository, SluggerInterface $slugger): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($program->getTitle());
            $program->setSlug($slug);

            $program->setOwner($this->getUser());

            $programRepository->save($program, true);

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to('your_email@example.com')
                ->subject('Une nouvelle série vient d\'être publiée !')
                ->html($this->renderView('Program/newProgramEmail.html.twig', ['program' => $program]));

            $this->getParameter('mailer_from');

            $mailer->send($email);


            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
            'program' => $program,

        ]);
    }

    #[Route('/{slug}/', name: 'show')]

    public function show(Program $program): Response

    {
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{slug}/season/{season}', requirements: ['season' => '\d+'], methods: ['GET'], name: 'season_show')]
    public function showSeason(Season $season, Program $program): Response
    {
        return $this->render('season/season_show.html.twig', [
            'program' => $program,
            'season' => $season
        ]);
    }

    #[Route('/{slug}/season/{season}/episode/{episode}', requirements: ['season' => '\d+'], methods: ['GET', 'POST'], name: 'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode, Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $user = $this->getUser();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $comment->setEpisode($episode);

            $commentRepository->save($comment, true);

            $this->addFlash('success', 'The new comment has been created');

            return $this->redirectToRoute(
                'program_episode_show',
                [
                    'slug' => $program->getSlug(),
                    'season' => $season->getId(),
                    'episode' => $episode->getId(),
                ],
                Response::HTTP_SEE_OTHER
            );
        }
        return $this->render('episode/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/{slug}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function edit(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);

            if ($this->getUser() !== $program->getOwner()) {
                // If not the owner, throws a 403 Access Denied exception
                throw $this->createAccessDeniedException('Only the owner can edit the program!');
            }

            return $this->redirectToRoute('episode/episode_show.html.twig', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comment/edit.html.twig', [
            'program' => $program,
            'form' => $form,
        ]);
    }

    #[Route('{slug}', name: 'delete', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function delete(Request $request, Program $program, ProgramRepository $programRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $program->getId(), $request->request->get('_token'))) {
            $programRepository->remove($program, true);
        }

        return $this->redirectToRoute('program_index', [], Response::HTTP_SEE_OTHER);
    }
    /* #[Route('/show/{id<^[0-9]+$>}', requirements: ['page' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository, EpisodeRepository $episodeRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        $seasons = $seasonRepository->findBy(['program' => $program]);
        $episodes = $episodeRepository->findBy(['season' => $seasons]);
        // same as $program = $programRepository->find($id);

        if (!is_numeric($id)) {
            throw $this->createNotFoundException();
        }

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }

        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            'episodes' => $episodes
        ]);
    }

    #[Route('/{programId}/season/{seasonId}', name: 'season_show')]
    public function showSeason(int $programId, ProgramRepository $programRepository, int $seasonId, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->find($programId);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $programId . ' found in season\'s table.'
            );
        }
        $season = $seasonRepository->find($seasonId);
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : ' . $seasonId . ' found in program\'s table.'
            );
        }

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
        ]);
    }*/
}
