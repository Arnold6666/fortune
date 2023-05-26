<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- bootstrap 5  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>Blog</title>

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark px-5" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Blog</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        @if ($user)
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/create">新增文章</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/logout">登出</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-secondary mb-0 text-white ms-2" href="{{ route('myArticle')}}">{{ auth()->user()->name }} 的文章 </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/login">登入</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section>
        <div class="container">
            @if (Session::has('message'))
                <div class="alert alert-warning mt-5 text-center fs-3" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="col-10 m-auto mt-5 border p-4 border-info rounded">
                <form class="d-flex" role="search" action="{{ route('search') }}">
                    @csrf
                    <input class="form-control me-2" type="search" placeholder="搜尋標題" name="search">
                    <button class="btn btn-outline-primary" style="width:100px" type="submit">搜尋文章</button>
                </form>
                <hr>

                <h2 class="text-center">相關文章</h2>
                @foreach ($articles as $article)
                    <div class="card" style="col-12">
                        <img src={{ asset(substr($article->image_path, 1)) }} class="card-img-top w-100" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }} </h5>
                            <h6 class="card-title">作者：{{ $article->name }} </h6>
                            <p>文章標籤: <br>
                                @foreach ($article->hashtags as $hashtag)
                                    <form action="{{ route('search') }}" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="hashtag" value={{ $hashtag->name }}>
                                        <button class="btn btn-outline-success">{{ $hashtag->name }}</button>
                                    </form>
                                @endforeach
                            </p>
                            <p class="card-text">{{ Str::limit($article->content, 120) }}</p>
                            <p class="d-flex justify-content-around mb-0 align-items-center">
                                <a href={{ '/article/' . $article->id }} class="btn btn-primary">繼續閱讀</a>
                                <span>瀏覽人次：{{ $article->views }}</span>
                                <span>最新編輯時間：{{ $article->updated_at }}</span>
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
