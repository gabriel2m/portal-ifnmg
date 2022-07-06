<?php

namespace Tests\Feature\Api\Perfis;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function test_get()
    {
        $this
            ->get(route('api.perfis.index'))
            ->assertOk();
    }
}
