<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPasswordRequestType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $favoriteproduct = $entityManager->getRepository(User::class)->findBy(['id' => $user]);
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
             'favorite' => $favoriteproduct
            ]
        );
    }

    #[Route(path: '/déconexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/oublie-pass', name: 'forgotten_password')]
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        SendMailService $mail,
    ): Response{

        $form = $this->createForm(ResetPasswordRequestType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);

            if($user){
                //je génère un token de reinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetPassword($token);
                $entityManager->persist($user);
                $entityManager->flush();

                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                $context = compact('url', 'user');

                $mail->send(
                    'maxime1513@gmail.com',
                    $user->getEmail(),
                    'Reinitialisation de mot de passe',
                    'passwordReset',
                    $context
                );
                return $this->redirectToRoute('app_login');
            }
        }
        return $this->render('security/reset_password_request.html.twig',[
            'requestPass' => $form->createView()
        ]);
    }

    #[Route('/oublie-pass/{token}', name:'reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response{
        $user = $userRepository->findOneBy(['resetPassword' => $token]);
        if($user){
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $user->setResetPassword('');
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_login');
            }

        return $this->render('security/reset_password.html.twig',[
            'newPassword' => $form->createView()
        ]);
        }
        return $this->redirectToRoute('app_home_index');
    }
}
