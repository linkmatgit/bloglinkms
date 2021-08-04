<?php

declare(strict_types=1);

namespace App\Tests\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
use App\Tests\FixturesTrait;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PageControllerTest extends WebTestCase
{

    use FixturesTrait;

    public function testGetDashboardWithoutLogin(): void
    {

        $this->client->request('GET', '/admin');
        $this->assertResponseRedirects();
    }
    public function testGetDashboardAdmin(): void
    {
        $data = $this->loadFixtures(['users']);
        $this->login($data['user_admin']);
        $this->client->request('GET', '/admin/');
        $this->expectTitle('Dashboard');
    }
    public function testGetWithUserLogin(): void
    {
        $data = $this->loadFixtures(['users']);
        $this->login($data['user1']);
        $this->client->request('GET', '/admin/');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}
