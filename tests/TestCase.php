<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, WithFaker;

    public function actingAsRandom($guard = null)
    {
        return $this->actingAs(User::factory()->create(), $guard);
    }

    public function actingAsAdmin($guard = null)
    {
        return $this->actingAs(User::factory()->admin()->create(), $guard);
    }

    public function actingAsEditor($guard = null)
    {
        return $this->actingAs(User::factory()->editor()->create(), $guard);
    }

    public function actingAsTecnico($guard = null)
    {
        return $this->actingAs(User::factory()->tecnico()->create(), $guard);
    }
}
