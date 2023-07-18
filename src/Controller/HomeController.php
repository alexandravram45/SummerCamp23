<?php

namespace App\Controller;


use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'teams' => $teamRepository->orderByWins()
        ]);
    }

}