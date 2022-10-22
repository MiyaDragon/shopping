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
use App\Http\Requests\ProductIndexRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ProductIndexRequest $request
     * @return View
     */
    public function index(ProductIndexRequest $request): View
    {
        $getProductsQuery = Product::query()
        // 商品カテゴリで検索
        ->when($request->category() != 'all', function($query) use ($request){
            return $query->where('product_category_id', $request->category());
        })
        // 名称で検索
        ->when($request->keyword() != '', function($query) use ($request){
            return $query->where('name', 'LIKE', '%' . $request->keyword() . '%');
        })
        // 価格で検索
        ->when($request->price() != '', function($query) use ($request){
            return $query->where('price', $request->aboveBelow(), $request->price());
        })
        // 並び替え
        ->when($request->element() == 'order_no', function($query) use ($request){
            return $query->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                ->select('products.*')
                ->orderBy('product_categories.order_no', $request->direction())
                ->orderBy('products.id', 'asc');
        })
        ->when($request->element() != 'order_no', function($query) use ($request){
            return $query->orderBy($request->element(), $request->direction());
        });

        $products = $getProductsQuery->paginate($request->count());

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
