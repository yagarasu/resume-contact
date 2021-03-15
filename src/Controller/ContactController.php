<?php
namespace App\Controller;

use App\Contact\ContactValidator;
use App\Mailer\ContactMailer;
use App\Entity\RecentContact;
use App\Repository\RecentContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
  /**
   * POST /contact
   * Send contact form
   */
  public function send(Request $request, ContactMailer $mailer, RecentContactRepository $recentContactRepository, EntityManagerInterface $entityManager): JsonResponse
  {
    try {
      $latestContactRequests = $recentContactRepository->findLatestByIp($request->getClientIp());
      if (\count($latestContactRequests) > 0) {
        throw new \Exception('Flood protection triggered');
      }

      $contact = $request->toArray();

      ContactValidator::validate($contact);

      $mailer->sendContact($contact);

      $newLatestContactRequest = new RecentContact();
      $newLatestContactRequest->setEmail($contact['email']);
      $newLatestContactRequest->setIp($request->getClientIp());
      $newLatestContactRequest->setSentAtFromDate(new \DateTime());
      $entityManager->persist($newLatestContactRequest);
      $entityManager->flush();

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