<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => ['nullable', 'alpha_dash', 'min:4', 'confirmed'],
            'image_path' => ['nullable', 'file'],
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
            'image_path' => 'イメージ',
        ];
    }
}
