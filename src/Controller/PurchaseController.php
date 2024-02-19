<?php

namespace App\Controller;

use App\Entity\PurchaseRequest;
use App\Form\Type\PurchaseRequestType;
use App\Service\PaymentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\PricingService;
use Throwable;

class PurchaseController extends AbstractController
{
    private $pricingService;
    private $paymentService;

    public function __construct(
        PricingService $pricingService,
        PaymentService $paymentService
    ) {
        $this->pricingService = $pricingService;
        $this->paymentService = $paymentService;
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'])]
    public function purchaseAction(Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $purchaseRequest = new PurchaseRequest;
            $form = $this->createForm(PurchaseRequestType::class, $purchaseRequest);

            $form->submit($data);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->pricingService->calculatePrice($purchaseRequest);

                $this->paymentService->processPayment($purchaseRequest);
                return new JsonResponse(['message' => "Payment was successful."], JsonResponse::HTTP_OK);
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
