<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class GameType extends AbstractType
{

        public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startingDate')
            ->add('firstTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',

            ])
            ->add('secondTeam', EntityType::class, [
                'class' => Team::class,
                'choice_label' => 'name',
            ]);

    }

        public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);

    }
}
