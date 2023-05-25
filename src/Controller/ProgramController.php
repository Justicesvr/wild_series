<?php

namespace App\Controller;


use App\Repository\SeasonRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/program', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $programs = $programRepository->findAll();

        return $this->render(
            'program/index.html.twig',
            ['programs' => $programs]
        );
    }
    #[Route('/show/{id<^[0-9]+$>}', requirements: ['page' => '\d+'], methods: ['GET'], name: 'show')]
    public function show(int $id, ProgramRepository $programRepository, SeasonRepository $seasonRepository): Response
    {
        $program = $programRepository->findOneBy(['id' => $id]);
        $seasons = $seasonRepository->findAll();
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
            'seasons' => $seasons
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
            'season' => $season
        ]);
    }

    #[Route('/{seasonId}/episode/{episode}', name: 'episode_show')]
    public function showEpisode(int $seasonId, SeasonRepository $seasonRepository, int $episodeId, EpisodeRepository $episodeRepository): Response
    {
        $season = $seasonRepository->find($seasonId);
        if (!$season) {
            throw $this->createNotFoundException(
                'No season with id : ' . $seasonId . ' found in program\'s table.'
            );
        }

        $episode = $episodeRepository->find($episodeId);
        if (!$season) {
            throw $this->createNotFoundException(
                'No episode with id : ' . $episodeId . ' found in episode\'s table.'
            );
        }
        return $this->render('program/season_show.html.twig', [
            'season' => $season,
            'episode' => $episode
        ]);
    }
}
