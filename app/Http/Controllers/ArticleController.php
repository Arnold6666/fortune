<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_hashtag;
use App\Models\Comment;
use App\Models\Hashtag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $articles = Article::with('hashtags')->get();

        return view('index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hashtags = Hashtag::all();
        return view('create', compact('hashtags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $article = new Article;

        $hashtags = $request->hashtag_id;

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

                $articleId = $article->id;

                foreach($hashtags as $hashtag_id){
                    $article_hashtag = new Article_hashtag;
                    $article_hashtag->article_id = $articleId;
                    $article_hashtag->hashtag_id = $hashtag_id;
                    
                    $article_hashtag->save();
                }

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
        $article = Article::with('hashtags')->find($id);
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
        $article = Article::with('hashtags')->where('id', $id)->first();
        $hashtags = Hashtag::all();

        return view('edit', compact('article'), compact('hashtags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //

        $article = Article::where('id', $request->id)->first();

        $hashtags = $request->hashtag_id;

        Article_hashtag::where('article_id', $request->id)->delete();

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

                foreach($hashtags as $hashtag_id){
                    $article_hashtag = new Article_hashtag;
                    $article_hashtag->article_id = $request->id;
                    $article_hashtag->hashtag_id = $hashtag_id;
                    
                    $article_hashtag->save();
                }

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
