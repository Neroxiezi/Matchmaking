<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TagRequest;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag_list = Tag::all();
        return view('admin.tag-list', compact('tag_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag-add');
    }


    public function store(TagRequest $tagRequest)
    {
        $param['name'] = $tagRequest->input('name');
        $res = Tag::create($param);
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '添加成功']);
        }
        return response()->json(['code' => 405, 'msg' => '添加收纳']);
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


    public function edit(Tag $tag)
    {
        //dd($tag);
        return view('admin.tag-edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validate = Validator::make($request->all(), ['name' => 'required'], ['name.required' => '标签名称必须']);
        if ($validate->fails()) {
            return response()->json(['code' => 405, 'msg' => $validate->fails()]);
        }
        $tag->name = $request->input('name');
        $res = $tag->save();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '修改成功']);
        }
        return response()->json(['code' => 405, 'msg' => '修改失败']);
    }

    public function destroy(Tag $tag)
    {
        $res = $tag->delete();
        if ($res) {
            return response()->json(['code' => 200, 'msg' => '删除成功']);
        }
        return response()->json(['code' => 405, 'msg' => '删除失败']);
    }
}
