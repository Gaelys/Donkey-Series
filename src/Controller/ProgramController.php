<?php

namespace App\Controller;

use App\Entity\Program;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_program')]
    public function index(ProgramRepository $programRepository): Response
    {
        return $this->render('program/index.html.twig', [
            'programs' => $programRepository->findAll(),
        ]);
    }

    #[Route('/program/{id<^\d+$>}', methods: ["GET"], name: 'app_program_show')]
    public function show(int $id, Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'name' => $program,
        ]);
    }
}
