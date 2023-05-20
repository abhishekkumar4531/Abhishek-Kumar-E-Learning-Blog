<?php

namespace App\Controller;

use App\Service\SendMsg;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
  #[Route('/contact', name: 'app_contact')]
  public function index(Request $request): Response {
    if(isset($_POST['sendMessage'])) {
      $sendMsg = $request->request->all();
      if($sendMsg) {
        $userName = $sendMsg['userName'];
        $userEmail = $sendMsg['userEmail'];
        $userSub = $sendMsg['userSubject'];
        $userMsg = $sendMsg['userMessage'];
        $send = new SendMsg();
        $getOtp = $send->getEmail($userName, $userEmail, $userSub, $userMsg);
        $session = $request->getSession();
        if($session->get('userLoggedIn')) {
          return $this->render('contact/index.html.twig', [
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName'),
            'msg' => "We recieved your message, we will get in touch with you!!!"
          ]);
        }
        else {
          $session->invalidate();
          return $this->render('contact/index.html.twig', [
            'loginUrl' => "login",
            'loginValue' => "Join now",
            'regUrl' => "/register",
            'regValue' => "Sign up",
            'msg' => "We recieved your message, we will get in touch with you!!!"
          ]);
        }
      }
    }
    else {
      $session = $request->getSession();
      if($session->get('userLoggedIn')) {
        return $this->render('contact/index.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $session->invalidate();
        return $this->render('contact/index.html.twig', [
          'loginUrl' => "login",
          'loginValue' => "Join now",
          'regUrl' => "/register",
          'regValue' => "Sign up",
        ]);
      }
    }
  }

}
