<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
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
     * ログインテスト
     *
     * @return void
     */
    public function testLogin(): void
    {
        // ログインページへ遷移
        $response = $this->get(route('admin.login'));

        // 遷移先がログインページであるか確認
        $response->assertStatus(200);
        $response->assertViewIs('admin.auth.login');

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post(route('admin.login'),
            ['email' => $this->adminUser->email, 'password' => 'password']);

        // リダイレクトでホーム画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/home');

        // このユーザーがログイン認証されていることを確認
        $this->assertAuthenticatedAs($this->adminUser, 'admin');
    }

    /**
     * ログアウトテスト
     *
     * @return void
     */
    public function testLogout(): void
    {
        // ログイン状態の作成
        $response = $this->actingAs($this->adminUser, 'admin');
        // ログアウトページへ遷移
        $response = $this->get('/admin/home');
        $response->assertStatus(200);

        // コントローラー側にpostアクションを飛ばす
        $response = $this->post(route('admin.logout'));

        // リダイレクトでログイン画面へ遷移しているか確認
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        // このユーザーがログイン認証されていないことを確認
        $this->assertGuest('admin');
    }
}
