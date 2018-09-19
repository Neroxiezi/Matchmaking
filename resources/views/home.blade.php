@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">视频列表</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @if(count($video_list)>0)
                    @foreach($video_list as $item)
                        <div class="col-sm-6 col-md-3">
                            <a href="{{url('video/'.$item->id)}}">
                                <div class="thumbnail">
                                    <img src="{{$item->img}}" alt="...">
                                    <div class="caption">
                                        <h4><i class="fa fa-video-camera" aria-hidden="true"></i> {{$item->title}}</h4>
                                        <p>
                                            <i class="fa fa-times-circle-o" aria-hidden="true"></i> {{$item->created_at}}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
