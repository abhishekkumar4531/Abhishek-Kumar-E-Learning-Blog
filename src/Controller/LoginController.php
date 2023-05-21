<?php

namespace App\Controller;

use App\Entity\UserDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{

  public $user;
  public $entityManager;
  public $userRepo;

  public function __construct(EntityManagerInterface $entityManager) {
    $this->user = new UserDetails();
    $this->entityManager = $entityManager;
    $this->userRepo = $entityManager->getRepository(UserDetails::class);
  }

  #[Route('/login', name: 'app_login')]
  public function index(Request $request): Response {
    if(isset($_POST['submitLogin'])) {
      $loginData = $request->request->all();
      if($loginData) {
        $loginOption = $loginData['loginOption'];
        if($loginOption === "loginwithemail") {
          $userEmail = $loginData['user_value'];
          $userPassword = $loginData['user_password'];
          $fetchCredentials = $this->userRepo->findOneBy([ 'userEmail' => $userEmail ]);
          if($fetchCredentials) {
            $validatePassword = $fetchCredentials->getUserPassword();
            if($validatePassword === $userPassword) {
              $session = $request->getSession();
              $session->set('userLoggedIn', $userEmail);
              $session->set('loggedImage', $fetchCredentials->getUserImage());
              $session->set('loggedName', $fetchCredentials->getUserFirstName());
              return $this->redirectToRoute('app_course');
            }
            else {
              return $this->render('login/index.html.twig', [
                'userValue' => $userEmail,
                'userPassword' => $userPassword,
                'invalidPassword' => "Please enter valid password",
                'loginUrl' => "login",
                'loginValue' => "Join now",
                'regUrl' => "/register",
                'regValue' => "Sign up"
              ]);
            }
          }
          else {
            return $this->render('login/index.html.twig', [
              'userValue' => $userEmail,
              'userPassword' => $userPassword,
              'invalidValue' => "Please enter valid email",
              'loginUrl' => "login",
              'loginValue' => "Join now",
              'regUrl' => "/register",
              'regValue' => "Sign up"
            ]);
          }
        }
        else if($loginOption === "loginwithename") {
          $userName = $loginData['user_value'];
          $userPassword = $loginData['user_password'];
          $fetchCredentials = $this->userRepo->findOneBy([ 'userName' => $userName ]);
          if($fetchCredentials) {
            $validatePassword = $fetchCredentials->getUserPassword();
            if($validatePassword === $userPassword) {
              $session = $request->getSession();
              $userEmail = $fetchCredentials->getUserEmail();
              $session->set('userLoggedIn', $userEmail);
              $session->set('loggedImage', $fetchCredentials->getUserImage());
              $session->set('loggedName', $fetchCredentials->getUserFirstName());
              return $this->redirectToRoute('app_home');
            }
            else {
              return $this->render('login/index.html.twig', [
                'userValue' => $userName,
                'userPassword' => $userPassword,
                'invalidPassword' => "Please enter valid password",
                'loginUrl' => "login",
                'loginValue' => "Join now",
                'regUrl' => "/register",
                'regValue' => "Sign up"
              ]);
            }
          }
          else {
            return $this->render('login/index.html.twig', [
              'userName' => $userName,
              'userPassword' => $userPassword,
              'invalidValue' => "Please enter valid user-name",
              'loginUrl' => "login",
              'loginValue' => "Join now",
              'regUrl' => "/register",
              'regValue' => "Sign up"
            ]);
          }
        }
        else {
          $adminEmail = $loginData['user_value'];
          $adminPassword = $loginData['user_password'];
          //$fetchCredentials = $this->userRepo->findOneBy([ 'userEmail' => $userEmail ]);
          if($adminEmail === "abhikrjha45@gmail.com") {
            //$validatePassword = $fetchCredentials->getUserPassword();
            if($adminPassword === "abhi45@AK") {
              $session = $request->getSession();
              $session->set('userLoggedIn', $adminEmail);
              $session->set('adminLoggedIn', TRUE);
              $session->set('loggedName', "Abhishek");
              //$session->set('loggedImage', $fetchCredentials->getUserImage());
              //$session->set('loggedName', $fetchCredentials->getUserFirstName());
              return $this->redirectToRoute('app_profile');
            }
            else {
              return $this->render('login/index.html.twig', [
                'userValue' => $adminEmail,
                'userPassword' => $adminPassword,
                'invalidPassword' => "Please enter valid password",
                'loginUrl' => "login",
                'loginValue' => "Join now",
                'regUrl' => "/register",
                'regValue' => "Sign up"
              ]);
            }
          }
          else {
            return $this->render('login/index.html.twig', [
              'userValue' => $adminEmail,
              'userPassword' => $adminPassword,
              'invalidValue' => "Please enter valid email",
              'loginUrl' => "login",
              'loginValue' => "Join now",
              'regUrl' => "/register",
              'regValue' => "Sign up"
            ]);
          }
        }
        /*else {
          $adminEmail = $loginData['user_value'];
          $adminPassword = $loginData['user_password'];
          //$fetchCredentials = $this->userRepo->findOneBy([ 'userEmail' => $userEmail ]);
          if($adminEmail === "abhikrjha45@gmail.com") {
            //$validatePassword = $fetchCredentials->getUserPassword();
            if($adminPassword === "abhi45@KU") {
              $session = $request->getSession();
              $session->set('userLoggedIn', $adminEmail);
              $session->set('bloggedLoggedIn', TRUE);
              $session->set('loggedName', "Abhishek");
              //$session->set('loggedImage', $fetchCredentials->getUserImage());
              //$session->set('loggedName', $fetchCredentials->getUserFirstName());
              return $this->redirectToRoute('app_profile');
            }
            else {
              return $this->render('login/index.html.twig', [
                'userValue' => $adminEmail,
                'userPassword' => $adminPassword,
                'invalidPassword' => "Please enter valid password",
                'loginUrl' => "login",
                'loginValue' => "Join now",
                'regUrl' => "/register",
                'regValue' => "Sign up"
              ]);
            }
          }
          else {
            return $this->render('login/index.html.twig', [
              'userValue' => $adminEmail,
              'userPassword' => $adminPassword,
              'invalidValue' => "Please enter valid email",
              'loginUrl' => "login",
              'loginValue' => "Join now",
              'regUrl' => "/register",
              'regValue' => "Sign up"
            ]);
          }
        }*/
      }
      else {
        return $this->render('login/index.html.twig', [
          'loginUrl' => "login",
          'loginValue' => "Join now",
          'regUrl' => "/register",
          'regValue' => "Sign up"
        ]);
      }
    }
    else {
      $session = $request->getSession();
      if($session->get('userLoggedIn')) {
        return $this->redirectToRoute('app_home');
      }
      else {
        $session->invalidate();
        return $this->render('login/index.html.twig', [
          'loginUrl' => "login",
          'loginValue' => "Join now",
          'regUrl' => "/register",
          'regValue' => "Sign up"
        ]);
      }
    }
  }

  #[Route('/logout', name: 'app_logout')]
  public function logout(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedin')) {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

}
