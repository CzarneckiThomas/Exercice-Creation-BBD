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
            'Site Promo',
            'Site Association',
            'Site entreprise',
        ];

        foreach ($projectNames as $projectName) {
            $project = new Project();
            $project->setName($projectName);
            $manager->persist($project);
        }

        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project->setName($faker->word());
            $manager->persist($project);
        }

        $manager->flush();
    }

    public function loadSchoolYears(ObjectManager $manager, FakerGenerator $faker)
    {
        $schoolYearsNames = [
            '2022',
            '2023',
            '2024',
        ];

        foreach ($schoolYearsNames as $schoolYearsName) {
            $tag = new SchoolYear();
            $tag->setName($schoolYearsName);
            $manager->persist($schoolyear);
        }

        for ($i = 0; $i < 10; $i++) {
            $tag = new SchoolYear();
            $tag->setName($faker->numberBetween(2022, 2032));
            $manager->persist($schoolYear);
        }

        $manager->flush();
    }

    public function loadStudents(ObjectManager $manager, FakerGenerator $faker): void
    {
        
        foreach ($students as $student) {
            $student = new Student();
            $student->setFirstname($studentFirstName);
            $student->setLastname($studentLastName);
            $student->setEmail($studentEmail);
            

        