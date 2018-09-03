<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BasicsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use BasicsTrait;

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function LoginIng(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => '用户名必须',
            'password.required' => '密码必须'
        ]);
        if ($validator->fails()) {
            $warnings = $validator->messages()->first();
            return $this->output_error($warnings);
        }
        $res = auth('admin')->attempt(['username' => $request->input('username'), 'password' => $request->input('password')],1);
        if ($res) {
            return $this->output_data('登录成功');
        }
        return $this->output_error('用户名或密码错误');
    }

    public function logout()
    {
        auth('admin')->logout();
        return redirect('admin/login');
    }
}
