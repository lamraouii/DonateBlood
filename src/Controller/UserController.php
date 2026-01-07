<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users')]
class UserController extends AbstractController
{

    #[Route('/', name :'users_list')]
    public function users(UserRepository $repo): Response
    {
        $users = $repo->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->render('Users/index.html.twig', [
            'users' => $data
        ]);
//      return $this->json($data); //hadi kanet dual tet
    }

    #[Route('/new', name: 'users_new')]
    public function newUser(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $user = new User();

        $form = $this->createForm(UserType::class, $user,[
            'submit_label' => 'Create user'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );

            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());

            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'User created successfully');

            return $this->redirectToRoute('users_list');
        }

        return $this->render('users/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name : 'users_edit', methods: ['GET','POST'])]
    public function editUser(User $user,Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher):Response{
    $form = $this->createForm(UserType::class, $user,[
        'submit_label' => 'Update user'
    ]);
    $form->handleRequest($request);
    if ($form -> isSubmitted() && $form->isValid()){
        $plainPassword = $form->get('password')->getData();
        if ($plainPassword) {
            $hashedPassword = $passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);}
        $em->flush();
        $this->addFlash('success','User updated sucflyy');
        return $this->redirectToRoute('users_list');
    }
        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);

    }


    #[Route('/{id}/delete', name: 'users_delete', methods: ['POST'])]
    public function delete(
        User $user,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete_user_'.$user->getId(), $request->request->get('_token'))) {
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', 'User deleted successfully');
        }

        return $this->redirectToRoute('users_list');
    }

}
