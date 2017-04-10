<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ArticleFormFields;
use App\Http\Requests\ArticleCreateRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Http\Controllers\Controller;
use App\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Auth;
class ArticleController extends Controller
{
    /**
     * Display a listing of the user's articles.
     */
    public function index()
    {
        $articles = Auth::user()->articles()->paginate(config('blog.posts_per_page'));
//        dd($articles);
//        $articles = Article::where('published_at', '<=', Carbon::now())
//            ->orderBy('published_at', 'desc')
//            ->paginate(config('blog.posts_per_page'));
//        dd($articles);
        return view('user.article.index', compact('articles'));
    }

    /**
     * Show the new article form
     */
    public function create()
    {
        $data = call_user_func([new ArticleFormFields(),'handle']);

        return view('user.article.create', $data);
    }

    /**
     * Store a newly created Post
     *
     * @param ArticleCreateRequest $request
     */
    public function store(ArticleCreateRequest $request)
    {
        $article = Article::create($request->articleFillData());
        $article->syncTags($request->get('tags', []));
        Auth::user()->articles()->attach($article);//为当前用户追加一篇文章。
        return redirect()
            ->route('article.index')
            ->withSuccess('New Article Successfully Created.');
    }

    /**
     * Show the article edit form
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data = call_user_func([new ArticleFormFields($id),'handle']);
//        $data = $this->dispatch(new ArticleFormFields($id));

        return view('user.article.edit', $data);
    }

    /**
     * Update the Article
     *
     * @param ArticleUpdateRequest $request
     * @param int $id
     */
    public function update(ArticleUpdateRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->fill($request->articleFillData());
        $article->save();
        $article->syncTags($request->get('tags', []));

        if ($request->action === 'continue') {
            return redirect()
                ->back()
                ->withSuccess('Article saved.');
        }

        return redirect()
            ->route('article.index')
            ->withSuccess('Article saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->tags()->detach();
        $article->delete();
        Auth::user()->articles()->detach($id);
        return redirect()
            ->route('article.index')
            ->withSuccess('Article deleted.');
    }
}
