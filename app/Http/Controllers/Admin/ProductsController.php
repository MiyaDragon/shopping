<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Consts\ProductsConst;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $category = $request->query('category') ?? ProductsConst::INITIAL_CATEGORY;
        $keyword = $request->query('keyword') ?? ProductsConst::INITIAL_KEYWORD;
        $price = $request->query('price') ?? ProductsConst::INITIAL_PRICE;
        $aboveBelow = $request->query('aboveBelow') == 'under' ? ProductsConst::UNDER : ProductsConst::OVER;
        $element = $request->query('element') ?? ProductsConst::INITIAL_ELEMENT;
        $direction = $request->query('direction') ?? ProductsConst::INITIAL_DIRECTION;
        $count = $request->query('count') ?? ProductsConst::INITIAL_COUNT;

        $products = Product::query();
        if($category <> 'all') {
            $products = $products->where('product_category_id', $category);
        }
        if($price <> '') {
            $products = $products->where('price', $aboveBelow, $price);
        }
        if($keyword <> '') {
            $products = $products->where('name', 'LIKE', '%'.$keyword.'%');
        }
        $products = $products->orderBy($element, $direction)->paginate($count);

        $productCategories = ProductCategory::all()->sortBy('order_no');

        return view('admin.products.index', [
            'products' => $products,
            'productCategories' => $productCategories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $productCategories = ProductCategory::all()->sortBy('order_no');

        return view('admin.products.create', ['productCategories' => $productCategories]);
    }

    /**
     * Store a newly created resource in storage.
     *f
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());

        if(!empty($request->file('image_path'))) {
            $file = $request->file('image_path');
            $file_name = $file->hashName();
            Storage::disk("public")
                ->putFileAs(ProductsConst::DIR, $request->file('image_path'), $file_name);
            $product->image_path = ProductsConst::DIR . '/' . $file_name;
            $product->save();
        }

        return redirect()->route('admin.products.show', ['product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $productCategories = ProductCategory::all()->sortBy('order_no');

        return view('admin.products.edit', [
            'product' => $product,
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        if(!empty($request->delete)) {
            Storage::disk(ProductsConst::DISK)->delete($product->image_path);
        }

        $product->update($request->validated());

        if(!empty($request->file('image_path'))) {
            Storage::disk(ProductsConst::DISK)->delete($product->image_path);
            $file = $request->file('image_path');
            $file_name = $file->hashName();
            Storage::disk(ProductsConst::DISK)
                ->putFileAs(ProductsConst::DIR, $request->file('image_path'), $file_name);
            $product->image_path = ProductsConst::DIR . '/' . $file_name;
            $product->save();
        }

        return redirect()->route('admin.products.show',
            ['product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        if(!empty($product->image_path)) {
            Storage::disk(ProductsConst::DISK)->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index');
    }
}
