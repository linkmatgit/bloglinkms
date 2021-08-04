<?php

namespace App\Http\Controller;

use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\Event\UserVerifiedEvent;
use App\Domain\Auth\Repository\UserRepository;
use App\Domain\Auth\User;
use App\Http\Form\RegistrationFormType;
use App\Infrastructure\Security\TokenGeneratorService;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{


    public function __construct(
        private EmailVerifier $emailVerifier,
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em,
        private TokenGeneratorService $generator
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder): Response
    {
        if ($this->getUser() !== null) {
            return $this->redirectToRoute('app_profil');
        }
        $user = new User();
        $rootErrors = [];
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setCreatedAt(new \DateTime());
            $user->setConfirmationToken($this->generator->generate(60));
            $this->em->persist($user);
            $this->em->flush();
            $this->addFlash(
                'success',
                'Un message avec un lien de confirmation vous a été envoyé par mail. 
                Veuillez suivre ce lien pour activer votre compte.'
            );
            $this->dispatcher->dispatch(new UserCreatedEvent($user));

            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'menu' => 'register',
            'errors' => $rootErrors,
        ]);
    }

    #[Route('/verify/email', name: 'verify_email')]
    public function verifyUserEmail(Request $request, UserRepository $userRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }
        $this->dispatcher->dispatch(new UserVerifiedEvent($user));
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_home');
    }


    #[Route('/inscription/confirmation/{id<\d+>}', name: 'register_confirm')]
    public function confirmToken(User $user, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $token = $request->get('token');
        if (empty($token) || $token !== $user->getConfirmationToken()) {
            $this->addFlash('error', "Ce token n'est pas valide");

            return $this->redirectToRoute('register');
        }

        if ($user->getCreatedAt() < new \DateTime('-2 hours')) {
            $this->addFlash('error', 'Ce token a expiré');

            return $this->redirectToRoute('register');
        }
        $user->setConfirmationToken(null);
        $user->setIsVerified(true);
        $em->flush();
        $this->addFlash('success', 'Votre compte a été validé.');

        return $this->redirectToRoute('app_login');
    }
}
