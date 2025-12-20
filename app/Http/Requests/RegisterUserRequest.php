<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
  
     public function rules()
     {
         return [
             'name' => 'required|string|max:255',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|string|confirmed|min:8',
             'company_name' => 'required|string|max:255',
         ];
     }
 
     public function messages()
     {
         return [
             'name.required' => 'الاسم مطلوب',
             'email.required' => 'البريد الإلكتروني مطلوب',
             'email.email' => 'البريد الإلكتروني غير صالح',
             'email.unique' => 'البريد الإلكتروني مستخدم مسبقًا',
             'password.required' => 'كلمة المرور مطلوبة',
             'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
             'company_name.required' => 'اسم الشركة مطلوب',
         ];
     }
}
