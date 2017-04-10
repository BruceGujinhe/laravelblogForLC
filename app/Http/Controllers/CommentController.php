<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Mail;
class CommentController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'comment_content' => 'required'
        ]);
        $comment = new Comment();
        $user = Auth::user();
        $comment->user_id = $user->id;
        $comment->comment_content = $request->get('comment_content');
        $comment->save();
        $articleId = $request->get('article_id');
        $article = Article::where('id','=',$articleId)->first();
        $article->comments()->attach($comment);

        // if current user_id doesn't equal current article's user_id, notice the Author(that is the article's user_id)
        $article_user = $article->users()->first();
        if($user->id != $article_user->id){
            $message = $user->name . " commented your article " .
                $article->title;
//            Notification::notify($article_user, new InvoicePaid($invoice));
//            $data['message'] = $message;
            $data['email'] = $article_user->email;
            $data['author_name'] = $article_user->name;
            $data['current_name'] = $user->name;
            $this->sendContactInfo($data,$message);
        }

        $user_icon = $user->icon_url;
        $username = $user->name;
        return response()->json([$comment,'user_icon' =>$user_icon,'username'=>$username,
            'articleId'=>$articleId]);
    }
    public function sendContactInfo($data, $msg)
    {
        $data['messageLines'] = explode("\n", $msg);

        Mail::send('user.notice', $data, function ($message) use ($data) {
            $message->subject('Blog Contact Form: '.$data['current_name'])
                ->to(config('blog.contact_email'))
                ->replyTo($data['email']);
        });
    }
    public function destroy($id) {
        $comment = Comment::find($id);
        $comment->delete();
        $article = $comment->articles()->first();
        $comment->articles()->detach($article->id);
        return response()->json(['success']);
    }

    public function show($id) {
        $comment = Comment::find($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'comment_content' => 'required'
        ]);
        $comment = Comment::find($id);
//        $comment->user_id = Auth::user()->id;
        $comment->comment_content = $request->get('comment_content');
        $comment->save();
        $user = User::where('id','=',$comment->user_id)->first();
        $user_icon = $user->icon_url;
        $username = $user->name;
        $articleId = $request->get('article_id');
        return response()->json([$comment,'user_icon' =>$user_icon,'username'=>$username,
            'articleId'=>$articleId]);
    }
}
