<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\SchoolYear;
use App\Entity\Student;
use App\Entity\Tag;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create('fr_FR');

        $this->loadProjects($manager, $faker);
        $this->loadSchoolYears($manager, $faker);
        $this->loadStudents($manager, $faker);
        $this->loadTags($manager, $faker);
    }



    public function loadSchoolYears(ObjectManager $manager, FakerGenerator $faker)
    {
        $schoolYearDatas = [
            [
                'name' => 'Alpha',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-07-01 09:00:00'),
                'finished_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-11-01 09:00:00'),
            ],
            [
                'name' => 'Beta',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2022-12-01 09:00:00'),
                'finished_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-03-01 09:00:00'),
            ],
            [
                'name' => 'Omega',
                'started_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-04-01 09:00:00'),
                'finished_at' => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2023-07-01 09:00:00'),
            ]
        ];

        foreach ($schoolYearDatas as $schoolYearData) {
            $schoolYear = new SchoolYear();
            $schoolYear->setName($schoolYearData['name']);
            $schoolYear->setStartedAt($schoolYearData['started_at']);
            $schoolYear->setEndDateAt($schoolYearData['finished_at']);

            
            $manager->persist($schoolYear);
        }
     
        for ($i = 0; $i < 10; $i++) {
            $schoolYear = new SchoolYear();
            $schoolYear->setName($faker->words(3,true));

            $date = $faker->dateTimeBetween('-6 month', '+6month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");

            $schoolYear->setStartedAt($date);
           


            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");

            $schoolYear->setEndDateAt($date);

            $manager->persist($schoolYear);
        }

        $manager->flush();
    }

    public function loadProjects(ObjectManager $manager, FakerGenerator $faker): void
    {
        $projectDatas = [
            [
                'name' => 'Site Particulier',
                'description' => 'Creation de site pour particulier'
            ],
            [
                'name' => 'Site Associations',
                'description' => 'Creation de site pour Assos'
            ],
            [
                'name' => 'Site Entreprise',
                'description' => 'Creation de site pour Entreprise'
            ],
            
        ];

        foreach ($projectDatas as $projectData) {
            $project = new Project();
            $project->setName($projectData['name']);
            $project->setDescription($projectData['description']);
            
            $manager->persist($project);
        }

        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project->setName($faker->word());
            $project->setDescription($faker->paragraph());

            $manager->persist($project);
        }

        $manager->flush();
    }

    

    public function loadStudents(ObjectManager $manager, FakerGenerator $faker): void
    {
        $repository = $this->doctrine->getRepository(SchoolYear::class);
        $schoolYears = $repository->findAll();

        $repository = $this->doctrine->getRepository(Tag::class);
        $tags = $repository->findAll();

        $studentDatas = 
        [
            [
                'Firstname' => 'Thomas',
                'Lastname' => 'Czar',
                'schoolYear' => $schoolYears[0],
                'tags' => [$tags[0], $tags[1]],
                'Email' => 'exemple@orange.fr'
            ],

            [
                'Firstname' => 'Marion',
                'Lastname' => 'Lero',
                'schoolYear' => $schoolYears[1],
                'tags' => [$tags[2], $tags[0]],
                'Email' => 'exemple@free.fr'
            ],

            [
                'Firstname' => 'Toto',
                'Lastname' => 'Tata',
                'schoolYear' => $schoolYears[2],
                'tags' => [$tags[1], $tags[2]],
                'Email' => 'exemple@sfr.fr'
            ],

        ];

        
        foreach ($studentDatas as $studentData) {
            $student = new Student();
            $student->setFirstname($studentData['firstname']);
            $student->setLastname($studentData['lastname']);
            $student->setEmail($studentData['Email']);
            $student->setSuccess(null);
            $student->setSchoolYear($studentData['schoolYear']);

            foreach ($studentData['tags'] as $tag) {
                $student->addTag($tag);
            }

            $manager->persist($studentData);

        }

        for ($i = 0; $i < 100; $i++) {
            $student = new Student();
            $student->setFirstname($faker->name());
            $student->setLastname($faker->name());
            $student->setEmail($faker->email());
            $student->setSucess(null);
            $schoolYear = $faker->randomElements($schoolYears)[0];
            $student->setSchoolYear($schoolYear);


            $manager->persist($student);

             // génération d'un nombre aléatoire compris entre 0 et 4 inclus
             $count = random_int(0, 4);
             $studentTags = $faker->randomElements($tags, $count);
 
             foreach ($studentTags as $tag) {
                 $student->addTag($tag);
             }
 
             $manager->persist($student);
         }
         $manager->flush();
     }

        

    public function loadTags(ObjectManager $manager, FakerGenerator $faker): void
    {
        $tagNames = [
            'HTML',
            'CSS',
            'Javascript',
        ];
        

        foreach ($tagNames as $tagName) {
            $tag = new Tag();
            $tag->setName($tagName);
            

            $manager->persist($tag);

        }

        for ($i = 0; $i < 10; $i++) {
            $tag = new Tag();
            $tag->setName($faker->word());
            $manager->persist($tag);

        }
        $manager->flush();
    }
}
    



