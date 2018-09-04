<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BasicsTrait;
use App\Helpers\Upload;
use App\Model\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    use Upload;
    use BasicsTrait;
    protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    public function index()
    {
        return view('admin.member-list');
    }

    public function create()
    {
        return view('admin.member-add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required',
            'sex' => 'required',
            'photo' => 'required',
            'password' => 'required',
            'repassword' => 'required',
        ], [
            'name.required' => '用户名必须',
            'username.required' => '昵称必须',
            'sex.required' => '性别必须',
            'photo.required' => '头像必须',
            'password.required' => '密码必须',
            'repassword.required' => '重复密码必须',
        ]);
        if ($validator->fails()) {
            $warnings = $validator->messages()->first();
            return $this->output_error($warnings);
        }
        if($request->input('password')!=$request->input('repassword')) {
            return $this->output_error('两次密码不一致');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function photo_upload(Request $request)
    {
        $data = $this->upload_local($request, 'file', 'uploads/photo');
        return $data;
    }
}
