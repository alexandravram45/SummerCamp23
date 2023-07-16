<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;


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

//                'query_builder' => function (EntityRepository $er) use ($options) {
//                    $firstTeamName = $options['data']->getFirstTeam();
//
//                    return $er->createQueryBuilder('t')
//                        ->where('t.name != :firstTeamName')
//                        ->setParameter('firstTeamName', $firstTeamName);
//                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
