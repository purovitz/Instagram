<?php

namespace App\Tests;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection;

class AuthorizationTest extends WebTestCase
{
    private KernelBrowser $client;
    private UserRepository|null $userRepo;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepo = static::getContainer()->get(UserRepository::class);

    }

    /** @test */

    public function an_admin_can_visit_the_admin_dashboard()
    {

    }
}

