<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\ProductCategory;

class ProductCategoriesControllerTest extends TestCase
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
    }

    /**
     * 商品カテゴリ作成テスト
     *
     * @return void
     */
    public function testCreate(): void
    {
        // 商品カテゴリ作成ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.product_categories.create'));

        // 遷移先が商品カテゴリ作成ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.product_categories.create');

        // 作成する値を定義
        $productCategory = [
            'name' => '作成成功',
            'order_no' => 1
        ];
        $url = route('admin.product_categories.store');

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post($url, $productCategory);

        // 商品カテゴリを作成後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $productCategory = ProductCategory::whereName('作成成功')->first();
        $response->assertRedirect('/admin/product_categories/' . $productCategory->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('product_categories', ['name' => '作成成功']);
    }

    /**
     * 商品カテゴリ更新テスト
     *
     * @return void
     */
    public function testUpdate(): void
    {
        // 商品カテゴリ編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.product_categories.edit', ['product_category' => $this->productCategory]));

        // 遷移先が商品カテゴリ編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.product_categories.edit');

        // 変更した値を定義
        $productCategory = [
            'name' => '編集成功',
            'order_no' => 1
        ];
        $url = route('admin.product_categories.update',
            ['product_category' => $this->productCategory]);

        // コントローラー側にputアクションを飛ばす
        $response = $this->put($url, $productCategory);

        // 商品カテゴリを編集後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/product_categories/' . $this->productCategory->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('product_categories', ['name' => '編集成功']);
    }

    /**
     * 商品カテゴリ削除テスト
     *
     * @return void
     */
    public function testDelete(): void
    {
        // 商品カテゴリ編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.product_categories.edit', ['product_category' => $this->productCategory]));

        // 遷移先が商品カテゴリ編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.product_categories.edit');

        // 削除予定のレコードが存在するか確認
        $this->assertDatabaseHas('product_categories', ['id' => $this->productCategory->id]);

        $url = route('admin.product_categories.destroy',
            ['product_category' => $this->productCategory]);

        // コントローラー側にdeleteアクションを飛ばす
        $response = $this->delete($url);

        // 商品カテゴリを削除後、リダイレクトで商品カテゴリ一覧画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/product_categories');

        // 削除したレコードが存在しないか確認
        $this->assertDatabaseMissing('product_categories', ['id' => $this->productCategory->id]);
    }
}
