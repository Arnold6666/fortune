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
    <title>Document</title>

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
            <div class="col-10 m-auto mt-5 border p-4 rounded">
                <div class="card" style="col-12">
                    <img src={{ $article->image }} class="card-img-top w-100" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <h6 class="card-title">作者：{{ $article->name }} </h6>
                        <p class="card-text">{{ $article->content }}</p>
                        <p class="d-flex justify-content-around mb-3 align-items-center">
                            <span>瀏覽人次：{{ $article->views }}</span>
                            <span>最新編輯時間：{{ $article->updated_at }}</span>
                        </p>
                        @if (Session::get('userId') === $article->user_id)
                            <div class="d-flex justify-content-around">
                                <a href={{ '/edit/' . $article->id }} class="btn btn-outline-success">編輯文章</a>
                                <form id="deleteForm" action="/delete/{{ $article->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger"
                                        onclick="deleteArticle()">刪除文章</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <hr>
            <div class="col-10 m-auto mt-3">
                <h2>留言區</h2>
                @if (Session::has('message'))
                    <div class="alert alert-warning mt-5 text-center fs-3" role="alert">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <form action="/comment/store" method="POST" id="comment"
                    class="d-flex justify-content-center align-items-center">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="user_id" value="{{ $user ? $user->id : '' }}">
                    <input type="hidden" name="name" value="{{ $user ? $user->name : '' }}">
                    <input type="hidden" name="article_id" value={{ $article->id }}>
                    <div class="mb-3 col-8 border border-secondary-subtle rounded">
                        <textarea class="form-control" style="resize: none; height: 100px" id="content" name="comment"></textarea>
                    </div>
                    <p class="text-center mb-0 col-4">
                        @if ($user)
                            <button type="button" class="btn btn-primary w-50" onclick="createComments()">
                                留言
                            </button>
                        @else
                            <button type="button" class="btn btn-primary w-50" onclick="alert('登入後才可以留言喔')">
                                留言
                            </button>
                        @endif

                    </p>
                </form>
            </div>
            <hr>

            <div class="col-10 m-auto mt-3">
                <h3>所有留言</h3>
                @foreach ($comments as $comment)
                    <div class="card w-100 mb-2">
                        <div class="card-body">
                            <h5 class="card-title d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="me-3"
                                    fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                </svg>
                                {{ $comment->name }}
                                <small class="ms-auto">{{ $comment->updated_at }}</small>

                                {{-- 如登入者與留言者為同一人 顯示編輯按鈕  --}}
                                @if ($user && $user->id === $comment->user_id)
                                    <button class="btn btn-outline-success ms-2 me-2" data-bs-toggle="modal"
                                        data-bs-target={{ '#comment' . $comment->id }}>編輯留言</button>

                                    <form id="deleteComment" action="/comment/delete/{{ $comment->id }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger"
                                            onclick="deleteComment()">刪除文章</button>
                                    </form>
                                @endif
                            </h5>

                            {{-- 同時生成對應編輯modal --}}
                            @if ($user && $user->id === $comment->user_id)
                                <div class="modal fade" id={{ 'comment' . $comment->id }} tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">編輯留言
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="/comment/update" method="POST">
                                                <div class="modal-body">
                                                    @csrf
                                                    {{-- @method('PATCH') --}}
                                                    <input type="hidden" name="_method" value="PATCH">
                                                    <input type="hidden" name="id" value={{ $comment->id }}>
                                                    <div class="mb-3 col-12 border border-secondary-subtle rounded">
                                                        <textarea class="form-control " style="resize: none; height: 100px" name="comment">{{ $comment->comment }}</textarea>
                                                    </div>

                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-toggle="modal" data-bs-dismiss="modal">取消編輯</button>
                                                    <button type="submit" class="btn btn-primary">編輯留言</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <p class="card-text text-secondary">{{ $comment->comment }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section>
        <div class="mt-5">
            <footer class="text-center text-lg-start text-white" style="background-color: #1c2331">
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                    © 2023 Copyright:
                    <span>a0919691671@gmail.com</span>
                </div>
            </footer>
        </div>
    </section>
    <script>
        function deleteArticle() {
            if (confirm("確定要刪除文章嗎？")) {
                document.getElementById('deleteForm').submit();
            }
        }

        function createComments() {
            document.getElementById('comment').submit();
        }

        function deleteComment() {
            if (confirm("確定要刪除留言嗎？")) {
                document.getElementById('deleteComment').submit();
            }
        }
    </script>
    {{-- bootstrap5 --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
