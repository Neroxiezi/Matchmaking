@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">视频播放</h3>
        </div>
        <div class="panel-body">
            <video id="my-video" class="video-js vjs-big-play-centered VideoSpeed" controls preload="auto" width="100%" height="550"
                   poster="{!! $course->img !!}" data-setup="{}">
                <source src="{{$course->video}}" type="video/mp4">
                <p class="vjs-no-js">
                    要查看此视频，请启用JavaScript，并考虑升级到web浏览器
                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>

                </p>
            </video>
        </div>
    </div>
    <script>
        require(['pfinaljs'], function (pfinaljs) {
            pfinaljs.video('my-video', function (video) {
                video.width(1000);
            })
        })
    </script>
@endsection
