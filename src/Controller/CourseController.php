<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
  #[Route('/course', name: 'app_course')]
  public function index(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      return $this->render('course/index.html.twig', [
        'loginUrl' => "logout",
        'loginValue' => "Logout",
        'regUrl' => "/profile",
        'regValue' => $session->get('loggedName')
      ]);
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/c', name: 'app_c')]
  public function c(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      return $this->render('course/c.html.twig', [
        'loginUrl' => "logout",
        'loginValue' => "Logout",
        'regUrl' => "/profile",
        'regValue' => $session->get('loggedName')
      ]);
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/java', name: 'app_java')]
  public function java(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      return $this->render('course/java.html.twig', [
        'loginUrl' => "logout",
        'loginValue' => "Logout",
        'regUrl' => "/profile",
        'regValue' => $session->get('loggedName')
      ]);
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

}
