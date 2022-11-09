<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UsersControllerTest extends TestCase
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
        $this->user = User::factory()->create();
    }

    /**
     * 顧客作成テスト
     *
     * @return void
     */
    public function testCreate(): void
    {
        // 顧客作成ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.users.create'));

        // 遷移先が顧客作成ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.create');

        // 作成する値を定義
        $data = [
            'name' => '作成テスト',
            'email' => 'create@create.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'image_path' => UploadedFile::fake()->image('create.jpg'),
        ];
        $url = route('admin.users.store');

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post($url, $data);

        // 顧客を作成後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $user = User::whereName('作成テスト')->first();
        $response->assertRedirect('/admin/users/' . $user->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('users', ['name' => '作成テスト']);
    }

    /**
     * 顧客更新テスト
     *
     * @return void
     */
    public function testUpdate(): void
    {
        // 顧客編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.users.edit', ['user' => $this->user]));

        // 遷移先が顧客編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');

        // 変更した値を定義
        $data = [
            'name' => '編集テスト',
            'email' => 'update@update.com',
            'password' => 'update',
            'password_confirmation' => 'update',
            'image_path' => UploadedFile::fake()->image('update.jpg'),
        ];
        $url = route('admin.users.update',
            ['user' => $this->user]);

        // コントローラー側にputアクションを飛ばす
        $response = $this->put($url, $data);

        // 顧客を編集後、リダイレクトで詳細画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/users/' . $this->user->id);

        // 作成したレコードが存在するか確認
        $this->assertDatabaseHas('users', ['name' => '編集テスト']);
    }

    /**
     * 顧客削除テスト
     *
     * @return void
     */
    public function testDelete(): void
    {
        // 顧客編集ページへ遷移
        $response = $this->actingAs($this->adminUser, 'admin')
            ->get(route('admin.users.edit', ['user' => $this->user]));

        // 遷移先が顧客編集ページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.users.edit');

        // 削除予定のレコードが存在するか確認
        $this->assertDatabaseHas('users', ['id' => $this->user->id]);

        $url = route('admin.users.destroy',
            ['user' => $this->user]);

        // コントローラー側にdeleteアクションを飛ばす
        $response = $this->delete($url);

        // 顧客を削除後、リダイレクトで顧客一覧画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/users');

        // 削除したレコードが存在しないか確認
        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
