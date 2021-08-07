<?php

namespace Tests\Feature\Perfil;

use App\Models\Perfil;
use Illuminate\Support\Str;
use Tests\TestCase;

abstract class SaveTestCase extends TestCase
{
    protected $perfisCount;

    /**
     * @return \Illuminate\Testing\TestResponse|array
     */
    protected function save($perfil = [], $categorias = [])
    {
        return array_merge($perfil, ['categorias' => $categorias]);
    }

    protected function assertSaveHasErrors(array $errors, $perfil = [], $categorias = [], int $perfisCount = null)
    {
        $response = $this
            ->save($perfil, $categorias)
            ->assertRedirect()
            ->assertSessionHasErrors($errors);
        $this->assertDatabaseCount(Perfil::class, $perfisCount ?? $this->perfisCount);
        return $response;
    }

    protected function assertSave($perfil = [], $categorias = [], array $categoriasSalvas = null)
    {
        $response = $this
            ->save($perfil, $categorias)
            ->assertRedirect(route('perfis.show', 1));

        $this->followRedirects($response)
            ->assertSee('Perfil Salvo');

        $this->assertDatabaseCount(Perfil::class, 1);
        $this->assertDatabaseHas(Perfil::class, $perfil);
        $this->assertTrue(
            Perfil::first()->categorias->pluck('id')->toArray() == ($categoriasSalvas ?? $categorias),
            'A relação de Categorias não foi salva'
        );
    }

    public function test_save_and_redirect_to_show_page()
    {
        $this->assertSave(
            perfil: [
                'nome' => Str::random(255),
                'descricao' => Str::random(1000),
            ],
            categorias: [1]
        );
    }

    public function test_save_with_multiple_categorias()
    {
        $this->assertSave(
            perfil: [
                'nome' => Str::random(255),
                'descricao' => Str::random(1000),
            ],
            categorias: [3, 1]
        );
    }

    public function test_save_categoria_pesquisa_add_laboratorio_and_prestacao_servico()
    {
        $this->assertSave(
            perfil: [
                'nome' => Str::random(255),
                'descricao' => Str::random(1000),
            ],
            categorias: [6],
            categoriasSalvas: [5, 6, 1]
        );
    }

    public function test_save_categoria_laboratorio_add_prestacao_servico()
    {
        $this->assertSave(
            perfil: [
                'nome' => Str::random(255),
                'descricao' => Str::random(1000),
            ],
            categorias: [5],
            categoriasSalvas: [5, 1]
        );
    }

    public function test_name_is_required()
    {
        $this->assertSaveHasErrors(
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

    public function test_categorias_is_required()
    {
        $this->assertSaveHasErrors(
            categorias: [],
            errors: ['categorias' => __('validation.required', ['attribute' => 'categorias'])]
        );
    }

    public function test_categorias_is_array()
    {
        $this->assertSaveHasErrors(
            categorias: 'tijolo',
            errors: ['categorias' => __('validation.array', ['attribute' => 'categorias'])]
        );
    }

    public function test_categoria_is_integer()
    {
        $this->assertSaveHasErrors(
            categorias: ['tijolo'],
            errors: ['categorias.0' => __('validation.integer', ['attribute' => 'categoria'])]
        );
    }

    public function test_categoria_exist()
    {
        $this->assertSaveHasErrors(
            categorias: [20],
            errors: ['categorias.0' => __('validation.in', ['attribute' => 'categoria'])]
        );
    }

    public function test_descricao_is_required()
    {
        $this->assertSaveHasErrors(
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
