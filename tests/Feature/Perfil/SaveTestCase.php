<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

abstract class SaveTestCase extends TestCase
{
    protected $perfisCount;

    /**
     * @return \Illuminate\Testing\TestResponse
     */
    abstract protected function save(array $perfil);

    protected function assertSaveHasErrors($perfil, array $errors, int $perfisCount = null)
    {
        $response = $this
            ->save($perfil)
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
        $this->assertDatabaseCount(Perfil::class, $perfisCount ?? $this->perfisCount);
        return $response;
    }

    protected function assertSave($perfil = null)
    {
        $response = $this
            ->save($perfil)
            ->assertRedirect(route('perfis.show', 1));

        $this->followRedirects($response)
            ->assertSee('Perfil Salvo');

        $this->assertDatabaseCount(Perfil::class, 1);
        $this->assertDatabaseHas(Perfil::class, $perfil);
    }

    public function test_save_and_redirect_to_show_page()
    {
        $this->assertSave(Perfil::factory()->makeOne([
            'nome' => Str::random(255),
            'descricao' => Str::random(1000)
        ])->toArray());
    }

    public function test_name_is_required()
    {
        $this->assertSaveHasErrors(
            perfil: [],
            errors: ['nome' => __('validation.required', ['attribute' => 'nome'])]
        );
    }

    public function test_name_is_string()
    {
        $this->assertSaveHasErrors(
            perfil: ['nome' => 1],
            errors: ['nome' => __('validation.string', ['attribute' => 'nome'])]
        );
    }

    public function test_name_max_255()
    {
        $this->assertSaveHasErrors(
            perfil: ['nome' => str_repeat('a', 256)],
            errors: ['nome' => __('validation.max.string', ['attribute' => 'nome', 'max' => '255'])]
        );
    }

    public function test_name_is_unique()
    {
        $perfil = Perfil::factory()->createOne();
        $this->assertSaveHasErrors(
            perfil: ['nome' => $perfil->nome],
            errors: ['nome' => __('validation.unique', ['attribute' => 'nome'])],
            perfisCount: $this->perfisCount + 1
        );
    }

    public function test_descricao_is_required()
    {
        $this->assertSaveHasErrors(
            perfil: [],
            errors: ['descricao' => __('validation.required', ['attribute' => 'descrição'])]
        );
    }

    public function test_descricao_is_string()
    {
        $this->assertSaveHasErrors(
            perfil: ['descricao' => 1],
            errors: ['descricao' => __('validation.string', ['attribute' => 'descrição'])]
        );
    }

    public function test_descricao_max_1000()
    {
        $this->assertSaveHasErrors(
            perfil: ['descricao' => str_repeat('a', 1001)],
            errors: ['descricao' => __('validation.max.string', ['attribute' => 'descrição', 'max' => '1000'])]
        );
    }
}
