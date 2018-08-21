<?php

namespace App\Controller;

use App\Form\UserRegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(UserRegistrationFormType::class);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			/** @var User $user */
			$user = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist($user);
			$em->flush();
			$this->addFlash('success', 'Welcome '.$user->getEmail());
			return $this->redirectToRoute('homepage');
		}

		return $this->render('user/registration.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
