<?php

namespace App\Http\Controllers;


use App\Model\Course;

class HomeController extends Controller
{

    protected $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function index()
    {
        $video_list = $this->course->paginate(15);
        return view('home', compact('video_list'));
    }

    public function course_info(Course $course)
    {
        $course->img = url($course->img);
        //$course->video = url(trim($course->video,'.'));
        return view('video',compact('course'));
    }
}
