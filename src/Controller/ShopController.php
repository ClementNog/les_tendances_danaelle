<?php

namespace App\Controller;

use App\Entity\Clothes;
use App\Repository\ClothesRepository;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;


class ShopController extends AbstractController
{
    #[Route('/shop', name: 'app_shop')]
    public function index(ClothesRepository $clothesRepository): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'clothes' => $clothesRepository->findAll(),
        ]);
    }

    // #[Route('/shop/{id}', name: 'app_shop')]
    // public function basket(BasketRepository $basketRepository, $id)
    // {
    //     $cookieName = 'basket'.uniqid();
    //     $cookie = new Cookie($cookieName, $id , time() + 3600);
    //     $basketRepository->save();
    //     // Créer une réponse HTTP
    //     $response = new Response();
    //     $response->headers->setCookie($cookie);

    //     // Retourner la réponse
    //     return $response;
    // }
}
