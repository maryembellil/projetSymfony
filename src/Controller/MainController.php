<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        $data = $this->getDoctrine()->getRepository(Users::class)->findAll();
        return $this->render('main/index.html.twig', [
            'list' => $data,
        ]);
    }

    /**
     * @Route("create", name="create")
     */

    public function create(Request $request){
        $crud = new Users();
        $form = $this->createForm(UsersType::class, $crud);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();
            
            $this->addFlash('notice', 'Submtted successfuly!!');

            return $this->redirectToRoute('main');
        }

        return $this->render('main/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request, $id){

        $crud = $this->getDoctrine()->getRepository(Users::class)->find($id);
        $form = $this->createForm(UsersType::class, $crud);
        $form ->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($crud);
            $em->flush();
            
            $this->addFlash('notice', 'update successfuly!!');

            return $this->redirectToRoute('main');
        }

        return $this->render('main/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id){

            $data = $this->getDoctrine()->getRepository(Users::class)->find($id);
            $em = $this->getDoctrine()->getManager();
            $em->remove($data);
            $em->flush();
            
            $this->addFlash('notice', 'Delete successfuly!!');

            return $this->redirectToRoute('main');
    }
    
}