<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $articles = Article::all();

        return view('index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $article = new Article;

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        if (isset($request->image)) {
            $data = $request->image->get();
            $mime_type = $request->image->getMimeType();
            $imageData = base64_encode($data);
            $src = "data:{$mime_type};base64,{$imageData}";
            $image = $src;
            // die($image);

            $article->name           = $request->name;
            $article->user_id        = $request->user_id;
            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->image          = $image;
            $article->created_at     = $dateTimeStr;
            $article->updated_at     = $dateTimeStr;

            try {
                $article->save();

                session()->flash('message', '新增成功');
                return redirect()->back();
            } catch (\Throwable $th) {
                session()->flash('message', $th->getMessage());
            }
        } else {
            $image = null;

            $article->name           = $request->name;
            $article->user_id        = $request->user_id;
            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->image          = $image;
            $article->created_at     = $dateTimeStr;
            $article->updated_at     = $dateTimeStr;

            try {
                $article->save();

                session()->flash('message', '新增成功');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorMessage = $e->getMessage();
                session()->flash('message', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $article = Article::where('id', $id)->first();
        $article->views += 1;
        $article->save();

        $comments = Comment::where('article_id', $id)->get();

        return view('article', compact('article'), compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $article = Article::where('id', $id)->first();

        return view('edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

        $article = Article::where('id', $request->id)->first();

        $dateTimeStr    = Carbon::now()->toDateTimeString();

        if (isset($request->image)) {

            // 將圖片轉為base64編碼存入資料型態為blob的欄位
            $data = $request->image->get();
            $mime_type = $request->image->getMimeType();
            $imageData = base64_encode($data);
            $src = "data:{$mime_type};base64,{$imageData}";
            $image = $src;
            // die($image);

            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->image          = $image;
            $article->updated_at     = $dateTimeStr;

            try {
                $article->save();

                session()->flash('message', '修改成功');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorMessage = $e->getMessage();
                session()->flash('message', $e->getMessage());
            }
        } else {

            $article->title          = $request->title;
            $article->content        = $request->content;
            $article->updated_at     = $dateTimeStr;

            try {
                $article->save();

                session()->flash('message', '修改成功');
                return redirect()->back();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorMessage = $e->getMessage();
                session()->flash('message', $e->getMessage());
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $article = Article::find($id);

        if ($article) {
            $article->delete();
            return redirect('/');
        } else {
            return "刪除失敗";
        }
    }

    public function search(Request $request)
    {
        $query = $request->search;

        $articles = Article::where('title', 'like', '%' . $query . '%')->get();

        return view('search', compact('articles'));
    }
}
