<?php

namespace App\Http\Admin\Controller;

use App\Infrastructure\Mailing\Mailer;
use App\Infrastructure\Queue\FailedJobsService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends BaseController
{
    protected string $menuItem = 'home';

    public function __construct(private FailedJobsService $failedJobs)
    {
    }

    #[Route("/", name: 'home')]
    public function home(): Response
    {

        return $this->render('admin/pages/home.html.twig', [
        'menu' => $this->menuItem,
            'failed_jobs' => $this->failedJobs->getJobs()
        ]);
    }

    /**
     * Envoie un email de test à mail-tester pour vérifier la configuration du serveur.
     *
     * @Route("/mailtester", name="mailtest", methods={"POST"})
     */
    public function testMail(Request $request, Mailer $mailer): RedirectResponse
    {
        $email = $mailer->createEmail('mails/auth/register.twig', [
            'user' => $this->getUserOrThrow(),
        ])
            ->to($request->get('email'))
            ->subject('Grafikart | Confirmation du compte');
        $mailer->sendNow($email);
        $this->addFlash('success', "L'email de test a bien été envoyé");

        return $this->redirectToRoute('admin_home');
    }
}
