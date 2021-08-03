<?php

namespace Tests\Feature\Perfil;

class CreateTest extends GuardTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->route = route('perfis.create');
    }

    public function test_display_create_page()
    {
        $this
            ->get($this->route)
            ->assertOk()
            ->assertSeeInOrder(
                values: [
                    "<title>Novo Perfil | " . config('app.name') . "</title>",
                    'Novo Perfil',
                    'action="' . route('perfis.store') . '"',
                ],
                escape: false
            );
    }
}
