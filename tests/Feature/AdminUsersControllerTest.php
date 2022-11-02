<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\AdminUser;

class AdminUsersControllerTest extends TestCase
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
    }

    /**
     * 管理者作成テスト
     *
     * @return void
     */
    public function testCreate(): void
    {
        // 管理者作成ページへ遷移
        $response = $this->get(route('admin.admin_users.create'));

        // 遷移先が管理者作成ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin_users.create');

        // 作成する値を定義
        $adminUser = [
            'name' => 'テスト',
            'email' => 'example@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'is_owner' => 0,
        ];
        $url = route('admin.admin_users.store');

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post($url, $adminUser);

        // 管理者を作成後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $adminUser = AdminUser::whereName('テスト')->first();
        $response->assertRedirect('/admin/admin_users/' . $adminUser->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('admin_users', ['name' => 'テスト']);
    }

    /**
     * 管理者更新テスト
     *
     * @return void
     */
    public function testUpdate(): void
    {
        // 管理者編集ページへ遷移
        $response = $this->get(route('admin.admin_users.edit', [
            'admin_user' => $this->adminUser,
        ]));

        // 遷移先が管理者編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin_users.edit');

        // 変更した値を定義
        $adminUser = [
            'name' => '編集成功',
            'email' => 'example@example.com',
            'password' => 'update',
            'password_confirmation' => 'update',
            'is_owner' => 0,
        ];
        $url = route('admin.admin_users.update',
            ['admin_user' => $this->adminUser]);

        // コントローラー側にputアクションを飛ばす
        $response = $this->put($url, $adminUser);

        // 管理者を編集後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/admin_users/' . $this->adminUser->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('admin_users', ['name' => '編集成功']);
    }

    /**
     * 管理者削除テスト
     *
     * @return void
     */
    public function testDelete(): void
    {
        // 管理者編集ページへ遷移
        $response = $this->get(route('admin.admin_users.edit', [
            'admin_user' => $this->adminUser,
        ]));

        // 遷移先が管理者編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin_users.edit');

        // 削除予定のレコードが存在するか確認
        $this->assertDatabaseHas('admin_users', ['id' => $this->adminUser->id]);

        $url = route('admin.admin_users.destroy',
            ['admin_user' => $this->adminUser]);

        // コントローラー側にdeleteアクションを飛ばす
        $response = $this->delete($url);

        // 管理者を削除後、リダイレクトで管理者一覧画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/admin_users');

        // 削除したレコードが存在しないか確認
        $this->assertDatabaseMissing('admin_users', ['id' => $this->adminUser->id]);
    }
}
