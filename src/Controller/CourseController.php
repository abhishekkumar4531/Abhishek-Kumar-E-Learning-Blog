<?php

namespace App\Controller;

use App\Entity\CourseDB;
use App\Entity\UserDetails;
use App\Entity\C;
use App\Entity\Cplus;
use App\Entity\Csharp;
use App\Entity\Java;
use App\Entity\Js;
use App\Entity\Python;
use App\Entity\Ts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{

  public $entityManager;
  public $courseData;
  public $courseRepo;
  public $course;
  public $cRepo;
  public $javaRepo;
  public $cPlusRepo;
  public $cSharpRepo;
  public $pythonRepo;
  public $jsRepo;
  public $tsRepo;

  public function __construct(EntityManagerInterface $entityManager) {
    $this->course = new CourseDB();
    $this->entityManager = $entityManager;
    $this->courseRepo = $entityManager->getRepository(CourseDB::class);
    $this->cRepo = $entityManager->getRepository(C::class);
    $this->javaRepo = $entityManager->getRepository(Java::class);
    $this->cPlusRepo = $entityManager->getRepository(Cplus::class);
    $this->cSharpRepo = $entityManager->getRepository(Csharp::class);
    $this->pythonRepo = $entityManager->getRepository(Python::class);
    $this->jsRepo = $entityManager->getRepository(Js::class);
    $this->tsRepo = $entityManager->getRepository(Ts::class);
  }

  #[Route('/course', name: 'app_course')]
  public function index(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchAllCourse = $this->courseRepo->findAll();
      foreach($fetchAllCourse as $singleCourse) {
        $uploadedCourses[] = $singleCourse;
      }
      return $this->render('course/index.html.twig', [
        'uploadedCourses' => $uploadedCourses,
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
      $fetchC = $this->courseRepo->findOneBy(['courceName' => "c"]);
      $fetchBlog = $this->cRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();

      if($fetchC === null) {
        return $this->render('course/c.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchC->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/c.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/c.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
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
      $fetchJava = $this->courseRepo->findOneBy(['courceName' => "java"]);
      $fetchBlog = $this->javaRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchJava === null) {
        return $this->render('course/java.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchJava->getCourceDes();
        if(isset($fetchSingle)) {
          // return $this->json(['property'=>$fetchSingle],200);
          // die();
          return $this->render('course/java.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/java.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/c++', name: 'app_cPlus')]
  public function cPlus(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchCplus = $this->courseRepo->findOneBy(['courceName' => "c++"]);
      $fetchBlog = $this->cPlusRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchCplus === null) {
        return $this->render('course/cPlus.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchCplus->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/cPlus.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/cPlus.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/c#', name: 'app_cSharp')]
  public function cSharp(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchCsharp = $this->courseRepo->findOneBy(['courceName' => "c#"]);
      $fetchBlog = $this->cSharpRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchCsharp === null) {
        return $this->render('course/cSharp.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchCsharp->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/cSharp.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/cSharp.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/python', name: 'app_python')]
  public function python(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchPython = $this->courseRepo->findOneBy(['courceName' => "python"]);
      $fetchBlog = $this->pythonRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchPython === null) {
        return $this->render('course/python.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchPython->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/python.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/python.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/javascript', name: 'app_javascript')]
  public function js(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchJs = $this->courseRepo->findOneBy(['courceName' => "javascript"]);
      $fetchBlog = $this->jsRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchJs === null) {
        return $this->render('course/js.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchJs->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/js.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/js.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

  #[Route('/course/typescript', name: 'app_typescript')]
  public function ts(Request $request): Response {
    $session = $request->getSession();
    if($session->get('userLoggedIn')) {
      $fetchTs = $this->courseRepo->findOneBy(['courceName' => "typescript"]);
      $fetchBlog = $this->tsRepo->findAll();
      $i=0;
      foreach($fetchBlog as $blog) {
        $fetchSingle[$i]['contentDesc'] = $blog->getContentDesc();
        $fetchSingle[$i]['contentFile'] = $blog->getContentFile();
        $fetchSingle[$i]['contentLink'] = $blog->getContentLink();
        $fetchSingle[$i]['fileType'] = $blog->getFileType();
        $fetchSingle[$i]['authorName'] = $blog->getAuthorName();
        $i++;
      }

      // return $this->json(['property'=> $fetchSingle, 'value' => $fetchSingle[0]['contentDesc']],200);
      // die();
      if($fetchTs === null) {
        return $this->render('course/ts.html.twig', [
          'loginUrl' => "logout",
          'loginValue' => "Logout",
          'regUrl' => "/profile",
          'regValue' => $session->get('loggedName')
        ]);
      }
      else {
        $value = $fetchTs->getCourceDes();
        if(isset($fetchSingle)) {
          return $this->render('course/ts.html.twig', [
            'decription' => $value,
            'courseBlogging' => $fetchSingle,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
        else {
          return $this->render('course/ts.html.twig', [
            'decription' => $value,
            'loginUrl' => "logout",
            'loginValue' => "Logout",
            'regUrl' => "/profile",
            'regValue' => $session->get('loggedName')
          ]);
        }
      }
    }
    else {
      $session->invalidate();
      return $this->redirectToRoute('app_login');
    }
  }

}
