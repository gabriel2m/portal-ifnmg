<?php

namespace Tests\Feature\Perfil;

class HomeTest extends IndexTest
{
    protected $route = 'home';

    protected function pageTitle()
    {
        return config('app.name');
    }
}
