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
                                <a class="nav-link" aria-current="page" href="/hushtag">文章標籤</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/logout">登出</a>
                            </li>
                            <li class="nav-item">
                                <p class="btn btn-outline-secondary mb-0 text-white ms-2">{{ auth()->user()->name }}</p>
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
        <div class="container ">
            @if (Session::has('message'))
                <div class="alert alert-warning mt-5 text-center fs-3" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
            <div class="row">
                <div class="col-4 m-0 mt-5 border p-4 border-info rounded">
                    <h2 class="text-center">新增標籤</h2>
                    <form action="/hashtag/store" method="post">
                        @csrf
                        @method('post')
                        <div class="mb-3">
                            <label for="name" class="form-label">標籤名稱</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <p class="text-center mb-0">
                            <button type="submit" class="btn btn-primary w-50">新增標籤</button>
                        </p>
                    </form>
                </div>
                <div class="col-8 m-0 mt-5 border p-4 border-info rounded text-around">
                    <h2 class="text-center">所有標籤</h2>
                    @foreach ($hashtags as $hashtag)
                        <button type="button" class="btn btn-secondary m-auto mb-2">{{ $hashtag->name }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
