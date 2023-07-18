<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameEditType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/game')]
class GameController extends AbstractController
{
    #[Route('/', name: 'app_game_index', methods: ['GET'])]
    public function index(GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll(),
        ]);
    }

    #[Route('/played', name: 'app_game_played', methods: ['GET'])]
    public function played(GameRepository $gameRepository): Response
    {
        return $this->render('game/played.html.twig', [
            'filteredGames' => $gameRepository->filterByPlayed()
        ]);
    }

    #[Route('/ordered', name: 'app_game_ordered', methods: ['GET'])]
    public function ordered(GameRepository $gameRepository): Response
    {
        return $this->render('game/ordered.html.twig', [
            'orderedGames' => $gameRepository->orderByStartingDate()
        ]);
    }

    #[Route('/new', name: 'app_game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GameRepository $gameRepository): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_game_show', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_game_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $game, GameRepository $gameRepository, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(GameEditType::class, $game);
        $form->handleRequest($request);

        $winnerID = $form->get('winnerID')->getData(); //luam numele echipei din form-ul cu winnerID
        $team = $teamRepository->findOneBy(['name' => $winnerID]); //salvam in team echipa care are numele egal cu winnerID

        $team?->setWins($team->getWins() + 1);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('game/edit.html.twig', [
            'game' => $game,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_game_delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $gameRepository->remove($game, true);
        }

        return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    }

}
