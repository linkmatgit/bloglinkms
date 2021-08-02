<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Accounts\Mods;

use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class OwnModControllerTest extends WebTestCase
{
    const CREATEMOD = '/profil/mods/new';
    private const CREATE_BUTTON = "Sauvegarder";

    use FixturesTrait;
    public function testGetModPageWithoutLogin():void
    {
        $this->client->request('GET', '/profil/mods');
        $this->assertResponseRedirects();
    }
    public function testGetModPageWithLogin():void
    {
        ['user1' => $user] = $this->loadFixtures(['users']);
        $this->login($user);
        $this->client->request('GET', '/profil/mods');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testGetPageCreateNew():void
    {
        ['user1' => $user] = $this->loadFixtures(['users']);
        $this->login($user);
        $this->client->request('GET', '/profil/mods/new');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testGetSubmitMod():void
    {
        ['user1' => $user] = $this->loadFixtures(['users']);
        $this->login($user);
        $this->client->request('GET', '/profil/mods/submit');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

}
