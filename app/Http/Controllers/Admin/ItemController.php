<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Requests\SaveItemRequest;
use App\Http\Requests\SearchItemRequest;
use App\Models\Item;
use App\Models\Unidade;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;

class ItemController extends ResourceController
{
    protected string $name = 'admin.itens';

    protected string $parameter = 'item';

    protected string $afterSaveRoute = 'admin.itens.show';

    public function __construct()
    {
        $this->authorizeResource(Item::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SearchItemRequest $request)
    {
        $item_search = new Item($request->validated());

        $itens = Item::query();

        $filters = array_filter($item_search->getAttributes());

        if ($nome_filter = Arr::pull($filters, 'nome'))
            $itens->where('nome', 'like', "%$nome_filter%");

        if ($descricao_filter = Arr::pull($filters, 'descricao'))
            $itens->where('descricao', 'like', "%$descricao_filter%");

        $itens->where($filters);

        return view('admin.itens.index', [
            'itens' => $itens->orderBy('nome')->paginate()->withQueryString(),
            'item_search' => $item_search,
            'unidades' => $this->unidades()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->form(new Item);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SaveItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveItemRequest $request)
    {
        return $this->save($request, new Item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('admin.itens.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return $this->form($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SaveItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(SaveItemRequest $request, Item $item)
    {
        return $this->save($request, $item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $response = redirect()->route("{$this->name}.index");
        if ($item->delete())
            return $response->with('warning', "Item \"$item->nome\" Deletado");
        return $response->with('danger', "Não foi possível deletar \"$item->nome\"");
    }

    protected function form(Model $model, array $data = [])
    {
        return parent::form($model, [
            'unidades' => $this->unidades(),
            ...$data
        ]);
    }

    protected function unidades()
    {
        return Unidade::orderBy('nome')->pluck('nome', 'id');
    }
}
