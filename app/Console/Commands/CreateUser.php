<?php

namespace App\Console\Commands;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UserValidationRules;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    use UserValidationRules;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria um novo usuário';

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
                'password_confirmation' => $this->secret('Confirme Password')
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
