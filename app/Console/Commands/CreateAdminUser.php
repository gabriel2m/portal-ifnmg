<?php

namespace App\Console\Commands;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\NivelUser;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um novo usuário admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            if ((new CreateNewUser)->create([
                'name' => $this->ask('Name'),
                'email' => $this->ask('Email'),
                'password' => $this->secret('Password'),
                'password_confirmation' => $this->secret('Confirme Password'),
                'nivel' => NivelUser::Admin->value
            ])) {
                $this->info("Usuário criado!");
                return 0;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->info('Erro ao validar:');
            foreach ($e->validator->errors()->all() as $error)
                $this->error($error);
            return 1;
        }
        $this->error("Algo deu errado!");
        return 1;
    }
}
