<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class WelcomeController extends AbstractController
{
  /**
   * GET /
   * Welcome Route
   */
  public function index(): JsonResponse
  {
    $response = new JsonResponse([
      'data' => [
        'app' => 'ah-resume-contact',
        'version' => '1.0.0'
      ]
    ]);

    return $response;
  }
}