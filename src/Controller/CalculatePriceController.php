<?php

namespace App\Controller;

use App\Entity\CalculatePriceRequest;
use App\Form\Type\CalculatePriceRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PricingService;
use Throwable;

class CalculatePriceController extends AbstractController
{
    private $pricingService;

    public function __construct(
        PricingService $pricingService
    ) {
        $this->pricingService = $pricingService;
    }

    #[Route('/calculate-price', name: 'app_calculate_price', methods: ['POST'])]
    public function calculatePriceAction(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $calculatePriceRequest = new CalculatePriceRequest;
            $form = $this->createForm(CalculatePriceRequestType::class, $calculatePriceRequest);

            $form->submit($data);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->pricingService->calculatePrice($calculatePriceRequest);

                return new JsonResponse(['price' => $calculatePriceRequest->getFinalPrice()], JsonResponse::HTTP_OK);
            }
            $errors = [];
            foreach ($form->getErrors(true, true) as $error) {
                $field = $error->getOrigin()->getName();
                $message = $error->getMessage();
                $errors[] = ['field' => $field, 'message' => $message];
            }

            return new JsonResponse(['errors' => $errors], JsonResponse::HTTP_BAD_REQUEST);
        } catch (Throwable $e) {
            return new JsonResponse(
                [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
    }
}
