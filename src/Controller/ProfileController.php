<?php

namespace App\Controller;

use App\Entity\C;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\UserDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FetchData;
use App\Entity\CourseDB;
use App\Entity\Cplus;
use App\Entity\Csharp;
use App\Entity\Java;
use App\Entity\Js;
use App\Entity\Python;
use App\Entity\Ts;
use App\Service\UpdateSlot;

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
  public $courseRepo;
  public $course;
  public $countSlot;

  public $cDB;
  public $cPlus;
  public $cSharp;
  public $javaDB;
  public $pythonDB;
  public $jsDB;
  public $tsDB;

  public function __construct(EntityManagerInterface $entityManager) {
    $this->user = new UserDetails();
    $this->course = new CourseDB();
    $this->entityManager = $entityManager;
    $this->userRepo = $entityManager->getRepository(UserDetails::class);
    $this->courseRepo = $entityManager->getRepository(CourseDB::class);
    $this->countSlot = new UpdateSlot($entityManager);
    $this->cDB = new C();
    $this->cPlus = new Cplus();
    $this->cSharp= new Csharp();
    $this->javaDB = new Java();
    $this->pythonDB = new Python();
    $this->jsDB = new Js();
    $this->tsDB = new Ts();
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
            'imageTypeError' => "Please select valid image[png, jpg, jpeg]",
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
          $this->countSlot->updateSlotCount('c');
        }
        if(!empty($userProfile['c++'])) {
          $userInterest['c++'] = $userProfile['c++'];
          $this->countSlot->updateSlotCount('c++');
        }
        if(!empty($userProfile['c#'])) {
          $userInterest['c#'] = $userProfile['c#'];
          $this->countSlot->updateSlotCount('c#');
        }
        if(!empty($userProfile['python'])) {
          $userInterest['python'] = $userProfile['python'];
          $this->countSlot->updateSlotCount('python');
        }
        if(!empty($userProfile['java'])) {
          $userInterest['java'] = $userProfile['java'];
          $this->countSlot->updateSlotCount('java');
        }
        if(!empty($userProfile['javascript'])) {
          $userInterest['javascript'] = $userProfile['javascript'];
          $this->countSlot->updateSlotCount('javascript');
        }
        if(!empty($userProfile['typescript'])) {
          $userInterest['typescript'] = $userProfile['typescript'];
          $this->countSlot->updateSlotCount('typescript');
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
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        return $this->redirectToRoute('app_home');
      }
    }
    else if(isset($_POST['submitChoice'])) {
      $session = $request->getSession();
      if($_POST['adminChoice'] === "addSub") {
        return $this->render('profile/add.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        return $this->render('profile/blog.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
    }
    else if(isset($_POST['submitCourse'])) {
      $session = $request->getSession();
      $courseData = $request->request->all();
      $fetchExistSub = $this->courseRepo->findOneBy([ 'courceName' => $courseData['courseName'] ]);
      if(!$fetchExistSub) {
        if($courseData) {
          $imgName = $_FILES['courseImage']['name'];
          $imgTmp = $_FILES['courseImage']['tmp_name'];
          $imgType = $_FILES['courseImage']['type'];
          if($imgType == "image/png" || $imgType == "image/jpeg" || $imgType == "image/jpg") {
            move_uploaded_file($imgTmp, "assets/courses/" . $imgName);
            $targetCourseImage = "assets/courses/" . $imgName;
            $this->course->setCourceName($courseData['courseName']);
            $this->course->setCourceDes($courseData['courseDesc']);
            $this->course->setCourceReach($courseData['courseSlots']);
            $this->course->setCourceDuration($courseData['courseDuration']);
            $this->course->setCourceImage($targetCourseImage);
            $this->course->setCourceAdmin($courseData['adminName']);
            $this->course->setCourceRated("15");

            $this->entityManager->persist($this->course);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_course');
          }
          else {
            return $this->render('profile/add.html.twig', [
              'loginUrl' => "logout",
              'loginValue' => "Logout",
              'regUrl' => "/profile",
              'regValue' => $session->get('loggedName'),
              'imageTypeError' => "Please select valid image[png, jpg, jpeg]"
            ]);
          }
        }
        else {
          return $this->render('profile/add.html.twig', [
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
      else {
        return $this->render('profile/add.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName'),
          'subExist' => $courseData['courseName']
        ]);
      }
    }
    else if(isset($_POST['submitBlog'])) {
      $session = $request->getSession();
      $courseData = $request->request->all();
      if($courseData) {
        $fileName = $_FILES['courseFile']['name'];
        $fileTmp = $_FILES['courseFile']['tmp_name'];
        $fileType = $_FILES['courseFile']['type'];

        move_uploaded_file($fileTmp, "assets/courses/" . $fileName);
        $targetCourseFile = "assets/courses/" . $fileName;
        $subName = $courseData['courseName'];
        if($subName === "c") {
          $this->cDB->setContentDesc($courseData['courseDesc']);
          $this->cDB->setContentLink($courseData['courseLink']);
          $this->cDB->setAuthorName($courseData['authorName']);
          $this->cDB->setContentFile($targetCourseFile);
          $this->cDB->setFileType($fileType);
          $this->entityManager->persist($this->cDB);
        }
        else if($subName === "java") {
          $this->javaDB->setContentDesc($courseData['courseDesc']);
          $this->javaDB->setContentLink($courseData['courseLink']);
          $this->javaDB->setAuthorName($courseData['authorName']);
          $this->javaDB->setContentFile($targetCourseFile);
          $this->javaDB->setFileType($fileType);
          $this->entityManager->persist($this->javaDB);
        }
        else if($subName === "c++") {
          $this->cPlus->setContentDesc($courseData['courseDesc']);
          $this->cPlus->setContentLink($courseData['courseLink']);
          $this->cPlus->setAuthorName($courseData['authorName']);
          $this->cPlus->setContentFile($targetCourseFile);
          $this->cPlus->setFileType($fileType);
          $this->entityManager->persist($this->cPlus);
        }
        else if($subName === "c#") {
          $this->cSharp->setContentDesc($courseData['courseDesc']);
          $this->cSharp->setContentLink($courseData['courseLink']);
          $this->cSharp->setAuthorName($courseData['authorName']);
          $this->cSharp->setContentFile($targetCourseFile);
          $this->cSharp->setFileType($fileType);
          $this->entityManager->persist($this->cSharp);
        }
        else if($subName === "python") {
          $this->pythonDB->setContentDesc($courseData['courseDesc']);
          $this->pythonDB->setContentLink($courseData['courseLink']);
          $this->pythonDB->setAuthorName($courseData['authorName']);
          $this->pythonDB->setContentFile($targetCourseFile);
          $this->pythonDB->setFileType($fileType);
          $this->entityManager->persist($this->pythonDB);
        }
        else if($subName === "javascript") {
          $this->jsDB->setContentDesc($courseData['courseDesc']);
          $this->jsDB->setContentLink($courseData['courseLink']);
          $this->jsDB->setAuthorName($courseData['authorName']);
          $this->jsDB->setContentFile($targetCourseFile);
          $this->jsDB->setFileType($fileType);
          $this->entityManager->persist($this->jsDB);
        }
        else if($subName === "typescript") {
          $this->tsDB->setContentDesc($courseData['courseDesc']);
          $this->tsDB->setContentLink($courseData['courseLink']);
          $this->tsDB->setAuthorName($courseData['authorName']);
          $this->tsDB->setContentFile($targetCourseFile);
          $this->tsDB->setFileType($fileType);
          $this->entityManager->persist($this->tsDB);
        }
        $this->entityManager->flush();

        return $this->redirectToRoute('app_course');
      }
      else {
        return $this->render('profile/add.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
    }
    else {
      $session = $request->getSession();
      if($session->get('userLoggedIn') && $session->get('adminLoggedIn')) {
        $adminEmail = $session->get('userLoggedIn');
        return $this->render('profile/admin.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      /*else if($session->get('userLoggedIn') && $session->get('bloggedLoggedIn')) {
        $adminEmail = $session->get('userLoggedIn');
        return $this->render('profile/blog.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }*/
      else if($session->get('userLoggedIn')) {
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

