<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta um usuário';

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

        /** @var User */
        if (!$user = User::where('name', $this->ask('Name'))->first()) {
            $this->error("Usuário não encontrado!");
            return 1;
        }
        if ($user->delete()) {
            $this->info("Usuário \"$user->name\" deletado!");
            return 0;
        }
        $this->error("Algo deu errado!");
        return 1;
    }
}
