<?php

namespace App\Controller;

ini_set('display_errors', 1); 
error_reporting(E_ALL);
use App\Services\AuthService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *  This Controller is responsible for managing user login and register 
 *  and redirection
 */
class AuthController extends AbstractController
{
  

  /**
   * Instance of Entity Manager interface
   * 
   * @var EntityManagerInterface $em 
   */
  private EntityManagerInterface $em;

  /**
   * Constructor is used to initilize entity manager variabe.
   * 
   * @param object $em 
   * Store the object of EntityManagerInterface Class.
   */
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  /**
   * Used to register the user and redirect accordingly.
   * 
   * @Route("/register" , name="register_route")
   * 
   * Instance of request
   * @param Request $request
   * 
   */
  public function register(Request $request): Response
  {

    if ($request->isXmlHttpRequest()) {

      $auth_service = new AuthService($this->em);
      $result = $auth_service->register($request);
     $this->sendResponse($result);
    }
    return $this->render('auth/register.html.twig');
  }


  /**
   * Used to Login the user and dedirect accordingly.
   * 
   * @Route("/login" , name="login_route")
   * 
   * Instance of request
   * @param Request $request
   */
  public function login(Request $request): Response
  {
    if ($request->isXmlHttpRequest()) {
      $auth_service = new AuthService($this->em);
      $result = $auth_service->login($request);
      $this->sendResponse($result);
    }
    return $this->render('auth/login.html.twig');
  }

  /**
   * Used to send response to ajax function.
   * 
   * @param array $data
   * This array contains the response result.
   * 
   */
  private function sendResponse($data)
  {
    $response = new JsonResponse();
    $response->setContent(json_encode($data));
    $response->headers->set('Content-Type', 'json');
    $response->send();
  }
  
}
