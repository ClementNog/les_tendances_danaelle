<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    #[Route('/pages', name: 'app_pages')]
    public function index(): Response
    {
        return $this->render('pages/aboutus.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/pages/checkout', name: 'app_pages_checkout')]
    public function checkout(): Response
    {
        return $this->render('pages/checkout.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/pages/shopdetails', name: 'app_pages_details')]
    public function detailq(): Response
    {
        return $this->render('pages/shopdetails.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }
    #[Route('/pages/shoppingcart', name: 'app_pages_cart')]
    public function cart(): Response
    {
        return $this->render('pages/shoppingcart.html.twig', [
            'controller_name' => 'PagesController',
        ]);
    }
}
