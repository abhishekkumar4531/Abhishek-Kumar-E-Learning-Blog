<?php

namespace App\Controller;

use App\Entity\UserDetails;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\SendOtp;

/**
 * ResetController
 * This is reponsible for reseting the user's password
 */
class ChangeController extends AbstractController
{

 /**
   * It will be the object of EntityManagerInterfaced.
   *
   * @var mixed
   */
  private $entityManager;

  /**
   * It will be store the repository of Users class.
   *
   * @var mixed
   */
  private $userRepo;

  /**
   * userData - It will store the user's personal data.
   *
   * @var array
   */
  private $userData = Array();

  /**
   * __construct - It will initialize the class and store objects in $entityManager,
   * and $userRepo.
   *
   *   @param  mixed $entityManager
   *     It is to manage persistance and retriveal Entity object from Database.
   *
   *   @return void
   */
  public function __construct(EntityManagerInterface $entityManager) {
    $this->entityManager = $entityManager;
    $this->userRepo = $entityManager->getRepository(UserDetails::class);
  }

  #[Route('/change', name: 'app_change')]
  /**
   * It is managing three cases
   * First case : It will fetch email from user and generate otp and send to the
   * user registered email.
   * Second case : It will fetch new password from form and update to the database.
   * Third case : Apart from above two cases it will check if user logged in or not,
   * if logged in then redirect to the home page otherwise redirect to login page.
   *
   *   @param  mixed $request
   *     This Request object is to handles the session.
   *
   *   @return Response
   *     If user submit generate otp page then render to reset page.
   *     If user submit reset page and if password reset done then redirect to
   *     login page otherwise render to reset page.
   *     If user direct try to access this controller then if logged in then
   *     redirect to home page otherwise redirect to login page.
   */
  public function index(Request $request): Response {
    if(isset($_POST['changePwd'])) {
      $session = $request->getSession();
      $this->userData['oldPassword'] = $_POST['oldPassword'];
      $checkCredentials = $this->userRepo->findOneBy([ 'userPassword' => $this->userData['oldPassword'] ]);
      if($checkCredentials) {
        $this->userData['newPassword'] = $_POST['newPassword'];
        $this->userData['cnfPassword'] = $_POST['cnfPassword'];
        if($this->userData['newPassword'] === $this->userData['cnfPassword']) {
          $checkCredentials->setUserPassword($this->userData['newPassword']);
          $this->entityManager->flush();
          return $this->redirectToRoute('app_profile');
        }
        else {
          return $this->render('reset/reset.html.twig', [
            'userData' => $this->userData,
            'invalidPassword' => 'Please enter same password',
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
      else {
        return $this->render('reset/reset.html.twig', [
          'userData' => $this->userData,
          'invalidOldPassword' => 'Please enter correct password',
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
    }
    else {
      $session = $request->getSession();
      if($session->get('userLoggedIn')) {
        return $this->render('change/index.html.twig', [
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
