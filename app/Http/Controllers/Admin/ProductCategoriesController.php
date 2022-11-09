<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryIndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\ProductCategory;
use App\Http\Requests\StoreProductCategoryRequest;

class ProductCategoriesController extends Controller
{
    private ProductCategory $productCategory;

    public function __construct(ProductCategory $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductCategoryIndexRequest $request
     *
     * @return view
     */
    public function index(ProductCategoryIndexRequest $request): View
    {
        $getProductCategoriesQuery = ProductCategory::query()
            // 名称で検索
            ->when($request->keyword() != '', function($query) use ($request) {
                return $query->where('name', 'LIKE', '%' . $request->keyword() . '%');
            })
            // 並び替え
            ->orderBy($request->element(), $request->direction());

        $productCategories = $getProductCategoriesQuery->paginate($request->count());

        return view('admin.product_categories.index',
            ['productCategories' => $productCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $productCategory = $this->productCategory;

        return view('admin.product_categories.create',
            ['productCategory' => $productCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProductCategoryRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreProductCategoryRequest $request): RedirectResponse
    {
        $productCategory = ProductCategory::create($request->validated());

        return redirect()->route('admin.product_categories.show',
            ['product_category' => $productCategory]);
    }

    /**
     * Display the specified resource.
     *
     * @param  ProductCategory  $productCategory
     * @return View
     */
    public function show(ProductCategory $productCategory): View
    {
        return view('admin.product_categories.show',
            ['productCategory' => $productCategory]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ProductCategory  $productCategory
     * @return View
     */
    public function edit(ProductCategory $productCategory): View
    {
        return view('admin.product_categories.edit',
            ['productCategory' => $productCategory]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreProductCategoryRequest  $request
     * @param  ProductCategory  $productCategory
     * @return RedirectResponse
     */
    public function update(StoreProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->update($request->validated());

        return redirect()->route('admin.product_categories.show',
            ['product_category' => $productCategory]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductCategory  $productCategory
     * @return RedirectResponse
     */
    public function destroy(ProductCategory  $productCategory): RedirectResponse
    {
        if ($productCategory->product->count() === 0) {
            $productCategory->delete();
        } else {
            abort(403);
        }

        return redirect()->route('admin.product_categories.index');
    }
}
