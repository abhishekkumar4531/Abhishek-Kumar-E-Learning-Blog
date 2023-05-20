<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FetchData;

/**
 * EditController
 * This class is extends with AbstractController
 * When user wants to edit or update his/her information then this class will be called.
 */
class ProfileController extends AbstractController {

  public $user;
  public $entityManager;
  public $userRepo;
  public $userData;

  public function __construct(EntityManagerInterface $entityManager) {
    $this->user = new UserDetails();
    $this->entityManager = $entityManager;
    $this->userRepo = $entityManager->getRepository(UserDetails::class);
  }

  #[Route('/profile', name: 'app_profile')]
  /**
   * Index function is performing two type of operations,
   * 1st operation : If user want to update/edit their information
   * 2nd operation : If user want to just view their personal information
   *
   *   @param  mixed $request
   *     This Request object is to handles the session.
   *
   *   @return Response
   *     If user submit edit button then after updating the values it will
   *     redirect to the edit page.
   *     And in other cases it will check user logged in and exits then render to
   *     the edit page or user not logged in then redirect to login page.
   */
  public function index(Request $request): Response {
    $getUserData = new FetchData();
    //When user submit the edit/update form then if statement will be execute.
    //It will fetch all the data from edit/update form and then update the form.
    //If this function will called through link, url or using navbar then else
    //statement will be execute.
    if(isset($_POST['updateBtn'])) {
      $session = $request->getSession();

      $userProfile = $request->request->all();

      $userEmail = $userProfile['user_email'];

      $userImage = $session->get('loggedImage');

      //If user want to also update their image then this statement will be execute.
      //It will check image type and then update the value of $userImage.
      if(!empty($_FILES['user_img']['name'])) {
        $imgName = $_FILES['user_img']['name'];
        $imgTmp = $_FILES['user_img']['tmp_name'];
        $imgType = $_FILES['user_img']['type'];

        //To check the image type, if condotion will be satisfied then
        //store the image in <uploads> folder.
        //If condition will not be satisfied then redirect to edit/update page with error message.
        if($imgType == "image/png" || $imgType == "image/jpeg" || $imgType == "image/jpg") {
          move_uploaded_file($imgTmp, "assets/uploads/". $imgName);
          $userImage = "assets/uploads/". $imgName;
        }
        else {
          $userData = $userProfile;
          return $this->render('profile/index.html.twig', [
            'userData' => $this->userData,
            'imageTypeError' => "Please select valid image",
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }

      $fetchData = $this->userRepo->findOneBy([ 'userEmail' => $userEmail ]);

      //If fetchData will be user's credential then only this statement will be execute.
      //Update the all the updated feilds of user.
      if($fetchData) {

        $userData = $getUserData->fetchUserProfile($this->userRepo, $request, $userEmail);

        $userSelectedSub = $userData['user_interest'];

        //$userInterest = $userSelectedSub;

        for ($i=0; $i < sizeof($userSelectedSub); $i++) {
          if($userSelectedSub[$i] === "C") {
            $userInterest['c'] = "C";
          }
          if($userSelectedSub[$i] === "C++") {
            $userInterest['c++'] = "C++";
          }
          if($userSelectedSub[$i] === "C#") {
            $userInterest['c#'] = "C#";
          }
          if($userSelectedSub[$i] === "Python") {
            $userInterest['python'] = "Python";
          }
          if($userSelectedSub[$i] === "Java") {
            $userInterest['java'] = "Java";
          }
          if($userSelectedSub[$i] === "JavaScript") {
            $userInterest['javascript'] = "JavaScript";
          }
          if($userSelectedSub[$i] === "TypeScript") {
            $userInterest['typescript'] = "TypeScript";
          }
        }

        if(!empty($userProfile['c'])) {
          $userInterest['c'] = $userProfile['c'];
        }
        if(!empty($userProfile['c++'])) {
          $userInterest['c++'] = $userProfile['c++'];
        }
        if(!empty($userProfile['c#'])) {
          $userInterest['c#'] = $userProfile['c#'];
        }
        if(!empty($userProfile['python'])) {
          $userInterest['python'] = $userProfile['python'];
        }
        if(!empty($userProfile['java'])) {
          $userInterest['java'] = $userProfile['java'];
        }
        if(!empty($userProfile['javascript'])) {
          $userInterest['javascript'] = $userProfile['javascript'];
        }
        if(!empty($userProfile['typescript'])) {
          $userInterest['typescript'] = $userProfile['typescript'];
        }

        $fetchData->setUserName($userProfile['user_name']);
        $fetchData->setUserFirstName($userProfile['first_name']);
        $fetchData->setUserMiddleName($userProfile['middle_name']);
        $fetchData->setUserLastName($userProfile['last_name']);
        $fetchData->setUserEmail($userProfile['user_email']);
        $fetchData->setUserMobile($userProfile['user_mobile']);
        $fetchData->setUserAge($userProfile['user_age']);
        $fetchData->setUserGender($userProfile['user_gender']);
        $fetchData->setUserCity($userProfile['user_city']);
        $fetchData->setUserCountry($userProfile['user_country']);
        $fetchData->setUserSubject("========");
        $fetchData->setUserImage($userImage);
        $fetchData->setUserInterests($userInterest);
        $this->entityManager->flush();
        $userData =  $getUserData->fetchUserProfile($this->userRepo, $request, $userEmail);
        return $this->render('profile/index.html.twig', [
          'userData' => $userData,
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => "userName"
        ]);
      }
      else {
        return $this->redirectToRoute('app_home');
      }
    }
    else {
      $session = $request->getSession();
      if($session->get('userLoggedIn')) {
        $userEmail = $session->get('userLoggedIn');
        $userData = $getUserData->fetchUserProfile($this->userRepo, $request, $userEmail);
        return $this->render('profile/index.html.twig', [
          'userData' => $userData,
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

}

