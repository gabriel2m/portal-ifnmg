<?php

namespace Tests\Feature\Auth\Password;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailTest extends TestCase
{
    public function test_post()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this
            ->post(route('password.email'), [
                'email' => $user->email
            ])
            ->assertRedirect();

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }
}
