<?php

namespace Tests\Feature\Contato;

use App\Models\User;
use App\Notifications\ContatoNotification;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendTest extends TestCase
{
    public function test_post()
    {
        Notification::fake();

        User::factory()->create();

        $this
            ->post(route('contato.send'), [
                'nome' => $this->faker->words(rand(1, 4), true),
                'email' => $this->faker->email(),
                'assunto' => $this->faker->text(),
                'mensagem' => $this->faker->text(),
            ])
            ->assertRedirect();

        Notification::assertSentTo(
            User::all(),
            ContatoNotification::class
        );
    }
}
