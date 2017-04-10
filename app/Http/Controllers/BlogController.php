<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Auth;
use App\User;

class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->paginate(config('blog.posts_per_page'));

        return view('blog.index', compact('articles'));
    }

    public function showArticle($id)
    {

        $article = Article::whereId($id)->firstOrFail();
        $user = $article->users()->first();
        $comments = $article->comments()->getResults();//直接使用$article->comments()时，会得到null的comment（查询官方文档）
//        dd($comments);
        return view('blog.article')->withArticle($article)->withUser($user)->withComments($comments);
    }
}
