<?php

namespace App\Http\Requests;

use App\Models\AdminUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required','string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(AdminUser::class)->ignore($this->admin_user->id)
            ],
            'password' => ['nullable', 'alpha_dash', 'min:4', 'confirmed']
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => '名称',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

}
