<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\NivelUser;
use App\Notifications\ContatoNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContatoController extends Controller
{
    public function show()
    {
        return view('contato.show');
    }

    public function send(Request $request)
    {
        Notification::send(
            User::where('nivel', NivelUser::Admin)->get(),
            new ContatoNotification($request->validate([
                'nome' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'string',
                    'max:255',
                    'email',
                ],
                'assunto' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'mensagem' => [
                    'required',
                    'string',
                    'max:1000',
                ],
            ]))
        );
        return to_route('portal.home')->with('success', 'Mensagem Enviada.');
    }
}
