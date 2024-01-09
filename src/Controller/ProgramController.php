<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/program/new', name: 'app_program_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(ProgramType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();
            return $this->redirectToRoute('app_program');
        }
        return $this->render('program/new.html.twig', [
            'form' =>$form,
        ]);
    }

    #[Route('/program/{id<^\d+$>}', methods: ["GET"], name: 'app_program_show')]
    public function show(Program $program): Response
    {
        return $this->render('program/show.html.twig', [
            'name' => $program,
            'seasons' => $program->getSeasons(),
        ]);
    }

    #[Route('/program/{programId}/season/{id<^\d+$>}', methods: ["GET"], name: 'app_season_show')]
    public function showSeason(Season $season) : Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $season->getProgram(),
            'season' => $season,
            'seasons' => $season->getEpisodes(),
        ]);
    }

    #[Route('/program/{program}/season/{season}/episode/{id<^\d+$>}', methods: ["GET"], name: 'app_episode_show')]
    public function showSEpisode(Program $program, Season $season, Episode $episode) : Response
    {
        return $this->render('program/episode_show.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
        ]);
    }
}
