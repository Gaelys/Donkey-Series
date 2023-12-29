<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    #[Route('/category/{name<^[A-z]+$>}', name: 'app_category_show')]
    public function show(Category $category, ProgramRepository $programRepository): Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'programs' => $programRepository->findBy(['category' => $category],  array('id' => 'desc'), 3)
        ]);
    }
}
