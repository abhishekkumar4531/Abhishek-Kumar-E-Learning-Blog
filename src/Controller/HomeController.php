<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  #[Route('/', name: 'app_home_default')]
  #[Route('/home', name: 'app_home')]
  public function index(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      return $this->render('home/index.html.twig', [
        'loginUrl' => "logout",
        'loginValue' => "Logout",
        'regUrl' => "/profile",
        'regValue' => $session->get('loggedName')
      ]);
    }
    else {
      $session->invalidate();
      return $this->render('home/index.html.twig', [
        'loginUrl' => "login",
        'loginValue' => "Join now",
        'regUrl' => "/register",
        'regValue' => "Sign up"
      ]);
    }
  }

}
