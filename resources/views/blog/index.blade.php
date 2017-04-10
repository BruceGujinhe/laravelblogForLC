@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h5>Page {{ $articles->currentPage() }} of {{ $articles->lastPage() }}</h5>
            <hr>
            <ul>
                @foreach ($articles as $article)
                    <li>
                        <a href="/blog/{{ $article->id }}">{{ $article->title }}</a>
                        <em>({{ $article->published_at }})</em>
                        <p>
                            {{ str_limit($article->content) }}
                        </p>
                    </li>
                @endforeach
            </ul>
            <hr>
            {!! $articles->render() !!}
        </div>
    </div>
@endsection

