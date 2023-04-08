<?php

namespace App\Controller;

use App\form\ProductPriceType;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProductPriceController extends AbstractController
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    #[Route('/', name: 'app_calc_price')]
    public function index(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(ProductPriceType::class, null, [
            'products' => $this->productService->getProductChoices()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $product = $data['product'];
            $country = substr($data['taxNumber'], 0, 2);

            $price = $this->productService->calculatePrice($product, strtolower($country));

            $session->getFlashBag()->set('price', $price);

            return $this->redirectToRoute('app_pay');
        }

        return $this->render('product_price/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pay', name: 'app_pay')]
    public function payProduct(SessionInterface $session)
    {
        $price = $session->getFlashBag()->get('price');

        if (!isset($price[0])) {
            return $this->redirectToRoute('app_calc_price');
        }

        return $this->render('product_price/pay.html.twig', [
            'price' => $price[0],
        ]);
    }
}
