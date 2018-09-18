<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BasicsTrait;
use App\Helpers\Upload;
use App\Model\Course;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    use Upload;
    use BasicsTrait;
    protected $tag;
    protected $course;

    public function __construct(Tag $tag,Course $course)
    {
        $this->tag = $tag;
        $this->course = $course;
    }

    public function index()
    {
        //echo public_path() . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "video";exit;
        return view('admin.course-list');
    }


    public function create()
    {
        $tag_list = $this->tag->get();
        return view('admin.course-add', compact('tag_list'));
    }


    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'photo'=>'required',
            'video'=>'required',
            'tag'=>'required'
        ],[
            'name.required'=>'名称不能为空',
            'photo.required'=>'名称不能为空',
            'video.required'=>'名称不能为空',
            'tag.required'=>'名称不能为空',
        ]);
        if ($validator->fails()) {
            $warnings = $validator->messages()->first();
            return $this->output_error($warnings);
        }
        $param['title'] = $request->input('name');
        $param['tag_id'] = $request->input('tag');
        $param['img'] = $request->input('photo');
        $param['video'] = $request->input('video');
        //dd($param);
        $res = $this->course->create($param);
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
        $data = $this->upload_local($request, 'file', 'uploads/course');
        return $data;
    }

    public function video_upload(Request $request)
    {
        return response()->json($this->upload_section($request));
    }
}
