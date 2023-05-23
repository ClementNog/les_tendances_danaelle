<?php

namespace App\Controller;

use App\Entity\Clothes;
use App\Form\ClothesType;
use App\Repository\ClothesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Persistence\ManagerRegistry;
// /**
//  * @IsGranted("ROLE_Admin")
//  * 
//  */
class ClothesController extends AbstractController
{
    #[Route('/newclothes', name: 'app_clothes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ClothesRepository $clothesRepository, SluggerInterface $slugger): Response
    {
        $clothes = new Clothes();
        $form = $this->createForm(ClothesType::class, $clothes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $imageFile = $form->get('image')->getData();
            
        

            // $em = $this->getDoctrine()->getManager();
            // $em->persist($clothes);
            // $em->flush();
            /**
             *  * @ParamConverter("post", options={"id" = "post_id"})
             */
            if ($imageFile) {
                $originalimagename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeimagename = $slugger->slug($originalimagename);
                $newimagename = $safeimagename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('brochures_directory'),
                        $newimagename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
    
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $clothes->setImagefile($newimagename);

            }
            $clothesRepository->save($clothes, true);

            return $this->redirectToRoute('app_clothes_index', [], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('clothes/new.html.twig', [
            'clothes' => $clothes,
            'form' => $form,
        ]);
        

    }
    #[Route('/clothes/{id}', name: 'app_clothes_show', methods: ['GET'])]
    public function show(Clothes $clothes): Response
    {
        return $this->render('clothes/show.html.twig', [
            'clothes' => $clothes,
        ]);
    }
    #[Route('/{id}', name: 'app_clothes_delete', methods: ['POST'])]
    public function delete(Request $request, Clothes $clothes, ClothesRepository $clothesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clothes->getId(), $request->request->get('_token'))) {
            $clothesRepository->remove($clothes, true);
        }

        return $this->redirectToRoute('app_clothes_index', [], Response::HTTP_SEE_OTHER);
    }
    
    #[Route('/clothes', name: 'app_clothes_index', methods: ['GET'])]
    public function index(ClothesRepository $clothesRepository): Response
    {
        return $this->render('clothes/index.html.twig', [
            'clothes' => $clothesRepository->findAll(),
        ]);
    }


   
    #[Route('clothes/{id}/edit', name: 'app_clothes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clothes $clothes, ClothesRepository $clothesRepository): Response
    {
        $form = $this->createForm(clothesType::class, $clothes);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clothesRepository->save($clothes, true);

            return $this->redirectToRoute('app_clothes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clothes/edit.html.twig', [
            'clothes' => $clothes,
            'form' => $form,
        ]);
    }




}
