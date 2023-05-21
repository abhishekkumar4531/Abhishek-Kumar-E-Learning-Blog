<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddCourseController extends AbstractController
{
    #[Route('/add/course', name: 'app_add_course')]
    public function index(): Response
    {
        return $this->render('add_course/index.html.twig', [
            'controller_name' => 'AddCourseController',
        ]);
    }
}
