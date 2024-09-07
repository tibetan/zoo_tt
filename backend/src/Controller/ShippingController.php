<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\ShippingService;

/**
 * Controller of Shipping
 *
 * Class ShippingController
 * @package App\Controller
 *
 * @author Yurii Martynovych tibet.mart@gmail.com
 */
class ShippingController extends AbstractController
{
    public function __construct(
        private ShippingService $shippingService,
    ) {
    }

    #[Route('/api/shipping', name: 'api_shipping_show', methods: ['GET'])]
    public function show(): JsonResponse
    {
        try {
            $shipping = $this->shippingService->getShipping();

            return $this->json($shipping);
        } catch (\Doctrine\DBAL\Exception $dbalException) {
            return new JsonResponse(['error' => 'Database error: ' . $dbalException->getMessage()], 500);
        } catch (\Doctrine\ORM\ORMException $ormException) {
            return new JsonResponse(['error' => 'ORM error: ' . $ormException->getMessage()], 500);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 400);
        }
    }

    #[Route('/api/shipping', name: 'api_shipping_calculate_price', methods: ['POST'])]
    public function calculatePrice(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['carrier']) || !isset($data['weight'])) {
            return new JsonResponse(['error' => 'Carrier and weight are required'], 400);
        }

        if ($data['weight'] <= 0) {
            return new JsonResponse(['error' => 'Weight must be grater than 0'], 400);
        }

        $carrier = $data['carrier'];
        $weight = (float) $data['weight'];

        try {
            $cost = $this->shippingService->calculate($carrier, $weight);
            $this->shippingService->saveShippingData($carrier, $weight, $cost);

            return new JsonResponse(['cost' => $cost], 201);
        } catch (\Doctrine\DBAL\Exception $dbalException) {
            return new JsonResponse(['error' => 'Database error: ' . $dbalException->getMessage()], 500);
        } catch (\Doctrine\ORM\ORMException $ormException) {
            return new JsonResponse(['error' => 'ORM error: ' . $ormException->getMessage()], 500);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'An unexpected error occurred: ' . $e->getMessage()], 400);
        }
    }
}
