@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {{--<div class="panel-heading"><h1>My Profile</h1></div>--}}

                    <div class="panel-body">
                        <img src="/upload/userimgs/{{$user->icon_url}}" style="width:150px;height: 150px;float: left;border-radius: 50%;margin-right: 30px">
                        <h2>{{$user->name}}'s Profile</h2>
                        <form enctype="multipart/form-data" action="/profile" method="POST">
                            <label>Update Profile Image</label>
                            <input type="file" name="icon_url">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="submit" class="pull-right btn btn-sm btn-primary">
                        </form>
                    </div>
                    {{--</div>--}}
                </div>
            </div>
        </div>
@endsection
