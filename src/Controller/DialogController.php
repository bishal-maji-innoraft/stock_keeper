<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;


/**
 * Contains methods for success and error dialog.
 */
class DialogController extends AbstractController
{
  /**
   * Opens Success page and perform redirection to route(nav_route) accordingly
   * 
   * @Route("/success/{message}/{nav_route}", name="success_route")
   * @param $message
   * @param $nav_route
   *
   */
  public function showSuccessDialog($message, $nav_route)
  {
    return $this->render('dialog/success_dialog.html.twig', ['message' => $message, 'nav_route' => $nav_route]);
  }

  /**
   * Opens error page and perform redirection to route(nav_route) accordingly
   * 
   * @Route("/error/{message}/{nav_route}", name="error_route")
   * @param $message
   * @param $nav_route
   *
   */
  public function showErrorDialog($message, $nav_route)
  {
    return $this->render('dialog/error_dialog.html.twig', ['message' => $message, 'nav_route' => $nav_route]);
  }
}
