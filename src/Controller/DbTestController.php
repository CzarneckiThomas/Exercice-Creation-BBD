<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\SchoolYear;
use App\Entity\Student;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController
{
    #[Route('/db/test', name: 'app_db_test')]
    public function index(): Response
    {
       // récupération du repository des projets
       $repository = $doctrine->getRepository(Project::class);
       // récupération de la liste complète de toutes les projets
       $projects = $repository->findAll();
       // inspection de la liste
       dump($projects);

       // récupération du repository des Schoolyear
       $repository = $doctrine->getRepository(SchoolYear::class);
       // récupération de la liste complète de tous les schoolyear
       $schoolYears = $repository->findAll();
       // inspection de la liste
       dump($schoolYears);

       // récupération du repository des Students
       $repository = $doctrine->getRepository(Student::class);
       // récupération de la liste complète de toutes les students
       $students = $repository->findAll();
       // inspection de la liste
       dump($students);

       // récupération du repository des Tags
       $repository = $doctrine->getRepository(Tag::class);
       // récupération de la liste complète de toutes les tags
       $tags = $repository->findAll();
       // inspection de la liste
       dump($tags);

    
    }
}
