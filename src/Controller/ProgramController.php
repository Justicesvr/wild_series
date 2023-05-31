<?php

namespace App\Controller;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository, RequestStack $requestStack): Response
    {
        $programs = $programRepository->findAll();
        $session = $requestStack->getSession();

        if (!$session->has('total')) {
            $session->set('total', 0); // if total doesn’t exist in session, it is initialized.
        }

        $total = $session->get('total'); // get actual value in session with ‘total' key.
        // ...
        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programRepository->save($program, true);
            $this->addFlash('success', 'The new program has been created');

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
            'program' => $program,

        ]);
    }

    #[Route('/program/{id}/', name: 'show')]

    public function show(Program $program): Response

    {
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/{program}/season/{season}', requirements: ['program' => '\d+', 'season' => '\d+'], methods: ['GET'], name: 'program_season_show')]
    public function showSeason(Season $season, Program $program): Response
    {
        return $this->render('program/season_show.html.twig', ['program' => $program, 'season' => $season]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}', requirements: ['program' => '\d+', 'season' => '\d+'], methods: ['GET'], name: 'program_episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', ['program' => $program, 'season' => $season, 'episode' => $episode]);
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
