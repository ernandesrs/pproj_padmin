<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Front\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Front/Products/List', [
            'products' => ProductResource::collection(Product::paginate(18)),
            'pageTitle' => 'Lista de produtos',
            "buttons" => [
                "new" => [
                    "icon" => "plusLg",
                    "text" => "Novo produto",
                    "url" => route("admin.products.create")
                ]
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Front/Products/Form', [
            'product' => [],
            'images' => session()->get('images', null),
            'pageTitle' => 'Novo produto',
            "buttons" => [
                "back" => [
                    "url" => route("admin.products.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create($validated);

        return redirect()->route("admin.products.edit", ["product" => $product->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Novo produto cadastrado com sucesso!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Product $product)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Front\Product  $product
     * @return \Inertia\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Front/Products/Form', [
            'product' => $product,
            'pageTitle' => 'Editar produto',
            'images' => session()->get('images', null),
            "buttons" => [
                "new" => [
                    "url" => route("admin.products.create")
                ],
                "back" => [
                    "url" => route("admin.products.index")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest  $request
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update($validated);

        return redirect()->route("admin.products.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "O produto foi atualizado com sucesso!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route("admin.products.index")->with("flash_alert", [
            "variant" => "warning",
            "message" => "O produto foi excluido com sucesso!"
        ]);
    }
}
