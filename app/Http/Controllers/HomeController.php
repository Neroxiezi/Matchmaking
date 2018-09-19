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
        return view('home');
    }
}
