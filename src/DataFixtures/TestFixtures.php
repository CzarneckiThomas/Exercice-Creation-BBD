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

    public function loadProjects(ObjectManager $manager, FakerGenerator $faker): void
    {
        $projectNames = [
            'Site Particuliers',
            'Site Associations',
            'Site Entreprises',
        ];

        foreach ($projectNames as $projectName) {
            $project = new Project();
            $project->setName($projectName);
            $project->setDescription($projectName['description']);
            
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

    public function loadSchoolYears(ObjectManager $manager, FakerGenerator $faker)
    {
        $schoolYears = [
            '2022',
            '2023',
            '2024',
        ];

        foreach ($schoolYears as $schoolYear) {
            $schoolYear = new SchoolYear();
            $schoolYear->setName($schoolYear);
            $schoolYear->setStarted_at($schoolYear['started_at']);
            $schoolYear->setFinished_at($schoolYear['finished_at']);

            
            $manager->persist($schoolyear);
        }

        for ($i = 0; $i < 10; $i++) {
            $schoolYear = new SchoolYear();
            $schoolYear->setName($faker->numberBetween(2022, 2032));

            $date = $faker->dateTimeThisYear();
            $date = DateTimeImmutable::createFromInterface($date);

            $schoolYear->setStarted_at($date);
            // $schoolYear->setFinished_at($faker->);
            $manager->persist($schoolYear);
        }

        $manager->flush();
    }

    public function loadStudents(ObjectManager $manager, FakerGenerator $faker): void
    {
        $students = [
            'Foo',
            'Bar',
            'Baz',
        ];
        
        foreach ($students as $student) {
            $student = new Student();
            $student->setFirstname($student['firstname']);
            $student->setLastname($student['lastname']);
            $student->setEmail($student['email']);
            $manager->persist($student);

        }

        for ($i = 0; $i < 10; $i++) {
            $student = new SchoolYear();
            $student->setFirstname($faker->name());
            $student->setLastname($faker->name());
            $student->setEmail($faker->email());

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
    



