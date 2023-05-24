<?php

namespace App\Controller;

// use App\Entity\Clothes;
// use App\Entity\Basket;
use App\Repository\ClothesRepository;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;


class ShopController extends AbstractController
{
    // , BasketRepository $basketRepository, User $users
    
    #[Route('/shop', name: 'app_shop')]
    public function index(ClothesRepository $clothesRepository, Request $request): Response
    {
        // if ($this->getUser()) {
        //      // Récupérer l'identifiant unique du cookie
        //     $cookieId = $request->cookies->get('cookie_panier_id');
        //     var_dump($cookieId);
        //     $user = $this->getUser();
        //     var_dump($user);
        //      // Si le cookie n'existe pas, générer un nouvel identifiant unique
        //     if (!$cookieId) {
        //         $cookieId = uniqid();
        //     }
        //     $id = $users->getId();
        //     $response = new Response();
        //     $response->headers->setCookie(new Cookie('cookie_panier_id', $cookieId));
        //     $basket = new Basket(uniqid(), $id, $cookieId, false);
        //     $basketRepository->save($basket);
        // }
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'clothes' => $clothesRepository->findAll(),
        ]);
    
    }
// mettre a jour le panier pour ajouter un vetement

    #[Route('/shop/basket/{id}', name: 'app_shop_basket')]
    public function basket(BasketRepository $basketRepository, $id)
    {
        $clothes = $basketRepository->getClothes();
        $clothes[] = $id;
        $basketRepository->setClothes($clothes);
        $basketRepository->update();
     //verifier que le cookie correspond bien a un panier

    }
}
