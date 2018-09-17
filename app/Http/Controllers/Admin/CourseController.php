<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\BasicsTrait;
use App\Helpers\Upload;
use App\Model\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    use Upload;
    use BasicsTrait;
    protected $tag;
    public  function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        //echo public_path() . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . "video";exit;
        return view('admin.course-list');
    }


    public function create()
    {
        $tag_list = $this->tag->get();
        return view('admin.course-add',compact('tag_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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
}
