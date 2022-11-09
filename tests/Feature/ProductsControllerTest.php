<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テストデータ作成
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->adminUser = AdminUser::factory()->create();
        $this->productCategory = ProductCategory::factory()->create();
        $this->product = Product::factory()->create(['product_category_id' => $this->productCategory->id]);
    }

    /**
     * 商品作成テスト
     *
     * @return void
     */
    public function testCreate(): void
    {
        // 商品作成ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.products.create'));

        // 遷移先が商品作成ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.create');

        // 作成する値を定義
        $product = [
            'product_category_id' => $this->productCategory->id,
            'name' => '作成成功',
            'price' => '100',
            'description' => 'テスト',
            'image_path' => UploadedFile::fake()->image('create.jpg'),
        ];
        $url = route('admin.products.store');

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post($url, $product);

        // 商品を作成後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $product = Product::whereName('作成成功')->first();
        $response->assertRedirect('/admin/products/' . $product->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('products', ['name' => '作成成功']);
    }


    /**
     * 商品更新テスト
     *
     * @return void
     */
    public function testUpdate(): void
    {
        // 商品編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.products.edit', ['product' => $this->product]));

        // 遷移先が商品編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.edit');

        // 変更した値を定義
        $product = [
            'product_category_id' => $this->productCategory->id,
            'name' => '編集成功',
            'price' => 100,
            'description' => '編集成功',
            'image_path' => UploadedFile::fake()->image('update.jpg')
        ];
        $url = route('admin.products.update',
            ['product' => $this->product]);

        // コントローラー側にputアクションを飛ばす
        $response = $this->put($url, $product);

        // 商品を編集後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/products/' . $this->product->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('products', ['name' => '編集成功']);
    }

    /**
     * 商品削除テスト
     *
     * @return void
     */
    public function testDelete(): void
    {
        // 商品編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.products.edit', ['product' => $this->product]));

        // 遷移先が商品編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.products.edit');

        // 削除予定のレコードが存在するか確認
        $this->assertDatabaseHas('products', ['id' => $this->product->id]);

        $url = route('admin.products.destroy',
            ['product' => $this->product]);

        // コントローラー側にdeleteアクションを飛ばす
        $response = $this->delete($url);

        // 商品を削除後、リダイレクトで商品一覧画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/products');

        // 削除したレコードが存在しないか確認
        $this->assertDatabaseMissing('products', ['id' => $this->product->id]);
    }
}
