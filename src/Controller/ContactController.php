<?php
namespace App\Controller;

use App\Contact\ContactValidator;
use App\Mailer\ContactMailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
  /**
   * POST /contact
   * Send contact form
   */
  public function send(Request $request, ContactMailer $mailer): JsonResponse
  {
    try {
      $contact = $request->toArray();

      ContactValidator::validate($contact);

      $mailer->sendContact($request->toArray());

      $response = new JsonResponse([
        'data' => [
          'success' => true
        ]
      ]);

      return $response;
    } catch (\Exception $e) {
      $response = new JsonResponse([
        'error' => $e->getMessage()
      ], JsonResponse::HTTP_BAD_REQUEST);

      return $response;
    } catch (\Exception $e) {
      $response = new JsonResponse([
        'error' => $e->getMessage()
      ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);

      return $response;
    }
  }
}