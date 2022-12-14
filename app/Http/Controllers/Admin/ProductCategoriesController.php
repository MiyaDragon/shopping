<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\ProductCategory;
use App\Http\Requests\StoreProductCategoryRequest;

class ProductCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     *
     * @return view
     */
    public function index(Request $request): View
    {
        $keyword = $request->query('keyword') ?? '';
        $element = $request->query('element') ?? 'id';
        $direction = $request->query('direction') ?? 'asc';
        $count = $request->query('count') ?? 10;

        $productCategories = ProductCategory::where('name', 'LIKE', '%'.$keyword.'%')
                            ->orderBy($element, $direction)
                            ->paginate($count);

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
        return view('admin.product_categories.create');
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
        if($productCategory->product->count() === 0) {
            $productCategory->delete();
        }else {
            abort(403);
        }

        return redirect()->route('admin.product_categories.index');
    }
}
