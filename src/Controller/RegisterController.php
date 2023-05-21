<?php

namespace App\Controller;

use App\Entity\UserDetails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{

  public $user;
  public $entityManager;
  public $userRepo;

  public function __construct(EntityManagerInterface $entityManager) {
    $this->user = new UserDetails();
    $this->entityManager = $entityManager;
    $this->userRepo = $entityManager->getRepository(UserDetails::class);
  }

  #[Route('/register', name: 'app_register')]
  public function index(Request $request): Response {
    if(isset($_POST['submitRegistration'])) {
      $newUserData = $request->request->all();
      if($newUserData) {

        $imgName = $_FILES['user_img']['name'];
        $imgTmp = $_FILES['user_img']['tmp_name'];
        $imgType = $_FILES['user_img']['type'];
        $userName = $newUserData['user_name'];
        $fetchUserName = $this->userRepo->findOneBy([ 'userName' => $userName ]);
        if(!$fetchUserName) {
          $userAge = number_format($newUserData['user_age']);
          if($userAge >= 15 && $userAge <= 100) {
            if($imgType == "image/png" || $imgType == "image/jpeg" || $imgType == "image/jpg") {
              move_uploaded_file($imgTmp, "assets/images/" . $imgName);
              $targetImage = "assets/images/" . $imgName;

              if(!empty($newUserData['c'])) {
                $userInterest['c'] = $newUserData['c'];
              }
              if(!empty($newUserData['c++'])) {
                $userInterest['c++'] = $newUserData['c++'];
              }
              if(!empty($newUserData['c#'])) {
                $userInterest['c#'] = $newUserData['c#'];
              }
              if(!empty($newUserData['python'])) {
                $userInterest['python'] = $newUserData['python'];
              }
              if(!empty($newUserData['java'])) {
                $userInterest['java'] = $newUserData['java'];
              }
              if(!empty($newUserData['javascript'])) {
                $userInterest['javascript'] = $newUserData['javascript'];
              }
              if(!empty($newUserData['typescript'])) {
                $userInterest['typescript'] = $newUserData['typescript'];
              }

              $this->user->setUserName($newUserData['user_name']);
              $this->user->setUserFirstName($newUserData['first_name']);
              $this->user->setUserMiddleName($newUserData['middle_name']);
              $this->user->setUserLastName($newUserData['last_name']);
              $this->user->setUserEmail($newUserData['user_email']);
              $this->user->setUserMobile($newUserData['user_mobile']);
              $this->user->setUserAge($newUserData['user_age']);
              $this->user->setUserGender($newUserData['user_gender']);
              $this->user->setUserCity($newUserData['user_city']);
              $this->user->setUserCountry($newUserData['user_country']);
              $this->user->setUserSubject("========");
              $this->user->setUserPassword($newUserData['user_password']);
              $this->user->setUserImage($targetImage);
              $this->user->setUserInterests($userInterest);

              $this->entityManager->persist($this->user);
              $this->entityManager->flush();

              return $this->redirectToRoute('app_login');
            }
            else {
              return $this->render('register/index.html.twig', [
                'userData' => $newUserData,
                'loginUrl' => "login",
                'loginValue' => "Join now",
                'regUrl' => "/register",
                'regValue' => "Sign up",
                'InvalidImg' => "Please upload valid image type[png, jpeg, jpg]"
              ]);
            }
          }
          else {
            return $this->render('register/index.html.twig', [
              'userData' => $newUserData,
              'loginUrl' => "login",
              'loginValue' => "Join now",
              'regUrl' => "/register",
              'regValue' => "Sign up",
              'invalidAge' => "Age should be numeric and range will be 15 to 100"
            ]);
          }
        }
        else {
          return $this->render('register/index.html.twig', [
            'userData' => $newUserData,
            'loginUrl' => "login",
            'loginValue' => "Join now",
            'regUrl' => "/register",
            'regValue' => "Sign up",
            'InvalidUserName' => "$userName already exist, please enter another username!!!"
          ]);
        }
      }
      else {
        return $this->render('register/index.html.twig', [
          'loginUrl' => "login",
          'loginValue' => "Join now",
          'regUrl' => "/register",
          'regValue' => "Sign up",
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
        return $this->render('register/index.html.twig', [
          'loginUrl' => "login",
          'loginValue' => "Join now",
          'regUrl' => "/register",
          'regValue' => "Sign up",
        ]);
      }
    }
  }

}
