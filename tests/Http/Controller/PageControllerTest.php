<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller;

use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PageControllerTest extends WebTestCase
{

    use FixturesTrait;

    public function testGetHomePage(): void
    {

        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testGetLoginWithSuccess(): void
    {
        $this->client->request('GET', '/login');
        $this->expectH1('Se connecter');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }

    public function testGetLoginWithRedirect():void
    {
        ['user1' => $user1, 'user_admin' => $admin] = $this->loadFixtures(['users']);
        $this->login($user1);
        $this->client->request('GET', '/login');
        $this->assertResponseRedirects();
    }
}
