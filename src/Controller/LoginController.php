<?php

namespace App\Controller;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use App\Entity\Basket;


class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/createcookie/{id}', name: 'app_create_cookie', methods: ['GET', 'POST'])]
    public function createcookie(Request $request, Basket $basket,BasketRepository $basketRepository, $id){
        
         // Récupérer l'identifiant unique du cookie
         $cookieId = $request->cookies->get('cookie_panier_id');
         dump($cookieId);

         // Si le cookie n'existe pas, générer un nouvel identifiant unique
         if (!$cookieId) {
             $cookieId = uniqid();
         }
         $response = new Response();
         $response->headers->setCookie(new Cookie('cookie_panier_id', $cookieId));
         $basket = new Basket(uniqid(), $id, $cookieId, false);
         $basketRepository->save($basket);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
