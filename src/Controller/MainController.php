<?php

namespace App\Controller;
ini_set('display_errors', 1); 
error_reporting(E_ALL);
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * MainController user for navigate to home if user already logged in.
 */
class MainController extends AbstractController
{

  /**
   * Route for user navigation to home or login page according to the login session of the user
   * 
   *  @Route("/", name = "app_main")
   * 
   *  instance of the request object
   *  @param Request $request
   * 
   *  @return Response
   * 
   */
  public function index(Request $request): Response
  {
    $cookie = $request->cookies;
    if (isset($_COOKIE['uid'])) {
      return $this->redirectToRoute('home_page_route');
    } else {
      return $this->render('main/index.html.twig');
    }
  }
}
