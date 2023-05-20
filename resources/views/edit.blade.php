<?php
use Illuminate\Support\Facades\Auth;

$user = Auth::user();

if ($article->user_id !== $user->id) {
    echo '<script>alert("您不具有編輯權限");</script>';
    header("Refresh: 0; url=/article/$article->id");
    // return redirect()->to("http://127.0.0.1:8000/article/" . $article->id);
}
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

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/create">新增文章</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/logout">登出</a>
                        </li>
                        <li class="nav-item">
                            <p class="btn btn-outline-secondary mb-0 text-white ms-2">{{ $user->name }}
                            </p>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section>
        <div class="container">
            @if (Session::has('message'))
                <div class="alert alert-primary mt-5 text-center fs-3" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="col-10 m-auto mt-5 border p-4 border-info rounded">
                <h2 class="text-center">編輯文章</h2>
                <form action="/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="title" class="form-label">標題</label>
                        <input type="hidden" value={{ $article->id }} name="id">
                        <input type="text" class="form-control" id="title" name="title"
                            value={{ $article->title }}>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">內文</label>
                        <textarea class="form-control" style="resize: none; height: 300px" id="content" name="content">{{ $article->content }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">文章照片</label>
                        <img src={{ $article->image }} class="mb-2 w-100 rounded" alt="">
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <p class="form-label">文章標籤</p>
                    @foreach ($hashtags as $hashtag)
                        @if ($article->hashtags)
                            @foreach ($article->hashtags as $articleHashtag)
                                @if ($hashtag->id === $articleHashtag->id)
                                    <div class="btn-group mb-2 me-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="{{ 'hashtag' . $hashtag->id }}"
                                            autocomplete="off" name="hashtag_id[]" value="{{ $hashtag->id }}" checked>
                                        <label class="btn btn-outline-primary"
                                            for="{{ 'hashtag' . $hashtag->id }}">{{ $hashtag->name }}</label>
                                    </div>
                                @else
                                    <div class="btn-group mb-2 me-2" role="group"
                                        aria-label="Basic checkbox toggle button group">
                                        <input type="checkbox" class="btn-check" id="{{ 'hashtag' . $hashtag->id }}"
                                            autocomplete="off" name="hashtag_id[]" value="{{ $hashtag->id }}">
                                        <label class="btn btn-outline-primary"
                                            for="{{ 'hashtag' . $hashtag->id }}">{{ $hashtag->name }}</label>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            @foreach ($hashtags as $hashtag)
                                <div class="btn-group mb-2 me-2" role="group"
                                    aria-label="Basic checkbox toggle button group">
                                    <input type="checkbox" class="btn-check" id="{{ 'hashtag' . $hashtag->id }}"
                                        autocomplete="off" name="hashtag_id[]" value="{{ $hashtag->id }}">
                                    <label class="btn btn-outline-primary"
                                        for="{{ 'hashtag' . $hashtag->id }}">{{ $hashtag->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                    <p class="text-center mb-0">
                        <button type="submit" class="btn btn-primary w-50">修改文章</button>
                    </p>
                </form>
            </div>
        </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
