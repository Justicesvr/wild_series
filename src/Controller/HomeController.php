<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {

        $programs = $programRepository->findBy(
            [],
            ['title' => 'ASC'],
        );

        return $this->render(
            'index.html.twig',
            ['programs' => $programs]
        );
    }
}
