<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected $admin = null;

    protected function setUp(): void {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    protected function signIn($user = null) {
        $user = $user ?: User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
