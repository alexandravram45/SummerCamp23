<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class GameEditType extends GameType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $game = $options['data'];

        $builder
            ->add('winnerID', ChoiceType::class, [
                'choices' => [
                    "{$game->getFirstTeam()}" => $game->getFirstTeam(),
                    "{$game->getSecondTeam()}" => $game->getSecondTeam(),
                ],
                'multiple' => false,
            ])
            ->add('endingDate');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}