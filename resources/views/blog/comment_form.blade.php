<div class="container">
    {{--task list--}}
    <div class="panel panel-default" style="border: 0px">
        <div class="panel-heading">
            文章评论：
        </div>
        <div id="comment-list">
            @foreach($comments as $comment)
                <div class="row" style="border-bottom:1px solid #f5f5f5;" id="comment{{$comment->id}}">
                    <div class="col-md-2" style="text-align: right;padding: 20px">
                        <img src="/upload/userimgs/{{App\User::find($comment->user_id)->icon_url}}"
                             style="width:100px;height: 100px;float: left;border-radius: 50%;margin-right: 5px;padding: 10px">
                        </br>
                        {{App\User::find($comment->user_id)->name}}
                    </div>
                    <div class="col-md-10"style="border-left:5px solid #f5f5f5;padding:20px">
                        <div class="row" style="border-bottom:2px solid #f5f5f5; padding-bottom: 10px">
                            {{$comment->comment_content}}
                        </div>
                        <div class="row"  style="margin-top: 10px">
                            <div class="col-md-4">{{$comment->updated_at}}</div>
                            <div class="col-md-2">&nbsp;</div>
                            <div class="col-md-6">
                                @if($comment->user_id == Auth::user()->id)
                                    <button  class="btn btn-info edit"
                                             value="{{$comment->id}}" style="margin-right: 15px">Update</button>
                                    <button class="btn btn-warning delete"
                                            value="{{$comment->id}}">Delete</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="row">
                <form id="comment">
                    <div class="form-group">
                        <label for="tcontent" class="control-label" id="comment-title">Content:</label>
                        <textarea class="form-control" id="comment_content" name="comment_content"></textarea>
                    </div>
                    {!! csrf_field() !!}
                </form>
            </div>
            <div class="row">
                <button type="button" id="tsave" class="btn btn-primary" value="add">Submit</button>
                <input type="hidden" id="tid" name="tid" value="-1">
                <input type="hidden" id="article_id" name="article_id" value="{{$article->id}}">
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/comment.js') }}"></script>