<?php

declare(strict_types=1);

namespace App\Tests\Http\Admin\Controller;

use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationControllerTest extends WebTestCase
{
    private const SIGNUP_PATH = '/register';
    private const SIGNUP_BUTTON = "Register";

    use FixturesTrait;

    protected ValidatorInterface $validator;

    public function testGetLoginWithRedirect(): void
    {
        ['user1' => $user1, 'user_admin' => $admin] = $this->loadFixtures(['users']);
        $this->login($user1);
        $this->client->request('GET', '/register');
        $this->assertResponseRedirects();
    }

    public function testFormRegisterWithBadInfo(): void
    {

        $this->client->request('GET', self::SIGNUP_PATH);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectH1('Inscription');
        $this->expectTitle('Inscription');

    }

    public function testRegisterEmail(): void
    {
        $crawler = $this->client->request('GET', self::SIGNUP_PATH);
        $form = $crawler->selectButton(self::SIGNUP_BUTTON)->form();
        $form->setValues([
            'registration_form' => [

                "name" => 'ahll32f',
                "email" => 'email@email.com',
                'plainPassword' => [
                    'first' => 'jane@doe.fr',
                    'second' => 'jane@doe.fr',
                ],
            ],
        ]);
        $this->client->submit($form);
        $this->expectFormErrors(0);
        $this->assertEmailCount(1);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        //  $this->expectAlert('success');
    }

    public function testRegisterWithValueExisting(): void
    {
        $user = $this->loadFixtures(['users']);
        $crawler = $this->client->request('GET', self::SIGNUP_PATH);
        $form = $crawler->selectButton(self::SIGNUP_BUTTON)->form();
        $formValues = [
            'registration_form' => [

                "name" => 'ahll32f',
                "email" => $user['user1']->getEmail(),
                'plainPassword' => [
                    'first' => 'jane@doe.fr',
                    'second' => 'jane@doe.fr',
                ],
            ],
        ];
        $form->setValues($formValues);
        $this->client->submit($form);
        $this->expectFormErrors(1);
        $this->assertEmailCount(0);
        $formValues['registration_form']['name'] = $user['user1']->getName();
        $form->setValues($formValues);
        $this->client->submit($form);
        $this->expectFormErrors(2);
        $this->assertEmailCount(0);
    }


}
