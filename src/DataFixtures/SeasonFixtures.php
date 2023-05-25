<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    const SEASONS = [
        [
            'number' => '1',
            'program' => 'program_0',
            'title' => 'Saison 1',
            'description' => 'La population entière a été ravagée par une épidémie d\'origine inconnue, qui est envahie par les morts-vivants. Parti sur les traces de sa femme Lori et de son fils Carl, Rick arrive à Atlanta où, avec un groupe de rescapés, il va devoir apprendre à survivre et à tuer tout en cherchant une solution ou un remède.',
            'year' => '2010',
        ],
        [
            'number' => '2',
            'program' => 'program_0',
            'title' => 'Saison 2',
            'description' => 'Lors de la deuxième saison le groupe de survivants mené par Rick Grimes tente de survivre dans un monde envahi par les rôdeurs, arrivant dans une ferme et découvrant peu à peu des éléments expliquant l\'épidémie. La famille Greene rejoint le groupe car de nouveaux liens se sont tissés entre certains personnages mais tous ne resteront pas indemnes, leur avenir étant incertain et de plus en plus hostile, dévasté au fil du temps.',
            'year' => '2011-2012',

        ],
        [
            'number' => '3',
            'program' => 'program_0',
            'title' => 'Saison 3',
            'description' => 'Après l\'attaque de la ferme des Greene par les morts-vivants, le groupe de Rick Grimes trouve refuge dans une prison infestée par les rôdeurs. De son côté, Andrea, qui erre dans la nature aux côtés de Michonne depuis des mois, fait la connaissance de Philip Blake, alias le Gouverneur, qui dirige la ville fortifiée de Woodbury. Si il parait sympathique au début, l\'homme se révèle être un dangereux psychopathe. Il tente d\'attaquer le groupe de Rick et de prendre d\'assaut la prison, sans succès. Dans un excès de rage, le Gouverneur massacre la quasi-totalité de son armée et prend la fuite.',
            'year' => '2012-2013',

        ],
        [
            'number' => '4',
            'program' => 'program_0',
            'title' => 'Saison 4',
            'description' => 'Après avoir retrouvé un semblant de vie au sein de la prison, le groupe de Rick, ayant recueilli des survivants de Woodbury, se retrouve confronté à une nouvelle épidémie. En effet, un virus mortel se répand au sein du refuge et décime plusieurs des survivants qui s\'y trouvent. Le Gouverneur, en cavale après les événements de la saison précédente, rejoint un autre groupe et se prépare à attaquer la prison à nouveau. Cependant, ce dernier est vaincu mais le groupe de Rick n\'a d\'autre choix que de prendre la fuite ; la prison tombe aux mains d\'une horde de rôdeurs. Éparpillés, Rick et les autres tentent de rejoindre une nouvelle destination appelée, le Terminus. Mais celle-ci risque de ne pas être ce à quoi ils s\'attendaient.',
            'year' => '2013-2014',

        ],
        [
            'number' => '5',
            'program' => 'program_0',
            'title' => 'Saison 5',
            'description' => 'La cinquième saison commence très peu de temps après l\'enfermement du groupe de Rick dans le wagon A au Terminus. Ils commencent à construire des armes à partir de leurs vêtements, leurs ceintures et du bois. Le groupe se prépare à attaquer ses ravisseurs à son entrée dans le conteneur, mais rien ne se passe comme prévu. Après les terribles événements, le groupe de survivants reprend sa route, les menant à l\'église Sainte-Sarah de Gabriel. Ils seront confrontés au retour du groupe cannibale de Gareth. Ils vont aussi devoir aller au Grady Memorial Hospital où Beth est retenue. Plus tard, ils découvrent la nouvelle communauté d\'Alexandria, dirigée par Deanna, qui va changer considérablement leur mode de vie.',
            'year' => '2014-2015',

        ],

        [
            'number' => '6',
            'program' => 'program_0',
            'title' => 'Saison 6',
            'description' => 'La sixième saison reprend juste après l\'exécution de Pete. Devenus membres de la communauté d\'Alexandria, Rick et ses coéquipiers vont devoir faire face à des agressions venant aussi bien de l\'extérieur que de l\'intérieur. Ils seront alors attaqués par un groupe particulièrement barbare et sanguinaire lors de la première moitié de la saison : les Wolves. La deuxième moitié de la saison révèle la présence de deux autres communautés : la Colline, qui ressemble un peu à Alexandria et les Sauveurs, principaux antagonistes qui obligent la Colline à leur fournir la moitié de leurs ressources. Le groupe des Sauveurs, sauvage et brutal est dirigé par le mystérieux et terrifiant Negan. Celui-ci menace la vie de Rick et de ses compagnons, mais ces derniers résistent et parviennent à en éliminer un certain nombre. Cependant, Negan et les Sauveurs arrivent à les piéger et à les capturer. Et afin de les asservir, il décide de les punir par l\'exécution d\'un des membres du groupe de Rick, en représailles pour les Sauveurs qui ont été massacrés.',
            'year' => '2015-2016',

        ],

        [
            'number' => '7',
            'program' => 'program_0',
            'title' => 'Saison 7',
            'description' => 'La septième saison reprend à partir des événements précédents de la sixième. Negan insuffle la peur et la crainte dans l\'esprit de Rick et son groupe après avoir exécuté Glenn et Abraham, plus la rébellion de Daryl, qui est par la suite emprisonné. Le groupe, alors amputé de trois membres, doit répondre aux besoins et ordres du chef des Sauveurs sous peine de nouvelles représailles. Après la rébellion de Rosita face à Negan, il exécute Olivia et Spencer puis enlève Eugene. Alexandria, qui est désormais menée par Rick, s\'associe à la Colline, menée par Maggie, et au Royaume, mené par le roi Ezekiel et sa tigresse nommée Shiva, pour contrer Negan et le reste des Sauveurs.',
            'year' => '2016-2017',

        ],

        [
            'number' => '8',
            'program' => 'program_0',
            'title' => 'Saison 8',
            'description' => 'À la suite de l\'alliance menée par Rick entre les trois communautés contre Negan et les Sauveurs : Alexandria, la Colline et le Royaume s\'unissent pour leur livrer une véritable guerre. Rick, Maggie et Ezekiel vont donc mener leurs troupes dans des batailles sans pitié afin d\'éradiquer les Sauveurs de la carte mais certains feront face à des enjeux moraux et la guerre pourrait ne pas se dérouler comme le voulait Rick. La guerre totale entre Rick et Negan est rendue au point de non-retour. Un duel entre Rick et Negan est inévitable. Lors de cet affrontement, Rick gagne en égorgeant Negan mais il ne le tue pas et choisit de l\'enfermer en cellule pour lui faire la morale. En faisant ce choix, il rend un dernier hommage aux conseils de son fils Carl, qui est quant à lui mort, ne pouvant profiter de la fin de cette guerre. Pourtant, Maggie se laisse ronger par la vengeance, le traumatisme de la mort de Glenn marque son attitude; elle n\'accepte pas le repentir des Sauveurs, et fomente leur fin.',
            'year' => '2017-2018',

        ],

        [
            'number' => '9',
            'program' => 'program_0',
            'title' => 'Saison 9',
            'description' => 'Un an et demi après la terrible guerre qui a opposé l\'Alliance menée par Rick et les Sauveurs menés par Negan, la vie semble s\'être apaisée et un semblant de civilisation commence à renaître grâce aux travaux de Rick. Mais la cohabitation avec les Sauveurs reste remplie de tensions et certains ont du mal à s\'y habituer. Tandis que les tensions grandissent de plus en plus, personne n\'aperçoit le véritable danger qui arrive et qui pourrait changer leur vie à tout jamais. Les Chuchoteurs menés par Alpha arrivent.',
            'year' => '2018-2019',

        ],

        [
            'number' => '10',
            'program' => 'program_0',
            'title' => 'Saison 10',
            'description' => 'Quelques mois après les événements décrits dans la saison précédente, les habitants d\'Alexandria et de la Colline vivent selon les nouvelles règles d\'Alpha. La paranoïa est présente et certains ont du mal à respecter les frontières imposées par les Chuchoteurs surtout après la mort de dix des leurs. Lorsqu\'un satellite s\'écrase en territoire Chuchoteurs, les protagonistes n\'ont pas d\'autre choix que de franchir la frontière pour éteindre le feu. Une décision qui ne va pas plaire à Alpha, qui va en profiter pour agrandir son territoire. La guerre contre les Chuchoteurs n\'a jamais été aussi proche et il se pourrait que les héros trouvent des alliés inattendus. Alpha et Bêta pensent être la fin du monde et comptent bien le prouver.',
            'year' => '2019-2021',

        ],

        [
            'number' => '11',
            'program' => 'program_0',
            'title' => 'Saison 11',
            'description' => 'L\'histoire se concentre sur la rencontre du groupe avec le Commonwealth, un vaste réseau de communautés disposant d\'un équipement de pointe et de plus de cinquante mille survivants vivant dans différentes colonies. Avec également une confrontation du groupe avec les Faucheurs, une mystérieuse faction de survivants hostiles qui ont attaqué et pris Meridian, l\'ancienne colonie de Maggie.',
            'year' => '2021-2022',

        ],

    ];

    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::SEASONS as $key => $seasons) {
            $season = new Season();
            $season->setNumber($seasons['number']);
            $season->setTitle($seasons['title']);
            $season->setDescription($seasons['description']);
            $season->setYear($seasons['year']);
            $season->setProgram($this->getReference($seasons['program']));

            $manager->persist($season);
            $this->addReference('season_' . $i, $season);

            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
