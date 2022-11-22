<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Front\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Front/Products/List', [
            'products' => Product::paginate(18),
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return Inertia::render('Admin/Front/Products/Form', [
            'product' => $product,
            'pageTitle' => 'Editar produto',
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Front\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
