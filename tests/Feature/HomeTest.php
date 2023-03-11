<?php

namespace Tests\Feature;
use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('portal.home'))
            ->assertOk();
    }
}
