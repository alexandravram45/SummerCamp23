<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TeamRepository $teamRepository, SluggerInterface $slugger): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if ($image) {
                $imageName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($imageName);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $team->setImage($newFilename);
                $teamRepository->save($team, true);
            }


            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }



    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'] )]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
    }

    public function wins(EntityManagerInterface $entityManager, string $name){
        $teamRepository = $entityManager->getRepository(Team::class);
        $gameRepository = $entityManager->getRepository(Game::class);

        $game = $gameRepository->findOneBy(['winnerID' => $name]);

    }
}
