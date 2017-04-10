@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $article->title }}</h1>
        <h5>{{ $article->published_at }}&nbsp;&nbsp;&nbsp;Author: {{$user?$user->name:'undefined'}}</h5>
        <hr>
        {!! nl2br(e($article->content)) !!}
        <hr>
        <button class="btn btn-primary" onclick="history.go(-1)">
            « Back
        </button>


        {{--@include('laravelLikeComment::like', ['like_item_id' => 'image_31'])--}}
        {{--@include('laravelLikeComment::comment', ['comment_item_id' => 'video_12'])--}}
        {{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>--}}
        {{--<script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>--}}
    </div>

    </br>
@endsection
