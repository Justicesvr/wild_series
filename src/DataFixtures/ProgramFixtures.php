<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        [
            'title' => 'The Walking Dead',
            'synopsis' => 'Des zombies envahissent la terre',
            'category' => 'category_Horror',
        ],
        [
            'title' => 'American Horror Story',
            'synopsis' => 'Faits divers comme des légendes urbaines et des histoires paranormales.',
            'category' => 'category_Horror',
        ],
        [
            'title' => 'Game of Thrones',
            'synopsis' => 'Neuf familles nobles rivalisent pour le contrôle du Trône de Fer dans les sept royaumes de Westeros.',
            'category' => 'category_Fantastique',
        ],
        [
            'title' => 'The Last of Us',
            'synopsis' => 'Le titre se déroule dans un univers post-apocalyptique après une pandémie provoquée par un champignon, le cordyceps, qui prend le contrôle de ses hôtes humains.',
            'category' => 'category_Horror',
        ],
        [
            'title' => 'Le Bureau des légendes',
            'synopsis' => 'Des agents du renseignement extérieur français sont en immersion à l\'étranger.',
            'category' => 'category_Drama',
        ],
        [
            'title' => 'OZ',
            'synopsis' => 'Emerald city. Quartier expérimental de la prison créé par Tim McManus qui souhaite améliorer les conditions de vie des détenus.',
            'category' => 'category_Drama',
        ],

    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::PROGRAMS as $key => $programs) {
            $program = new Program();
            $program->setTitle($programs['title']);
            $program->setSynopsis($programs['synopsis']);
            $program->setCategory($this->getReference($programs['category']));

            $manager->persist($program);
            $this->addReference('program_' . $i, $program);

            $i++;
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
