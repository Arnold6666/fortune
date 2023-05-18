<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $name           = $request->name;
        $user_id        = $request->user_id;
        $title          = $request->title;
        $content        = $request->content;
        $dateTimeStr    = Carbon::now()->toDateTimeString();
        $created_at     = $dateTimeStr;
        $updated_at     = $dateTimeStr;

        if (isset($request->image)) {
            $data = $request->new_image->get();
            $mime_type = $request->new_image->getMimeType();
            $imageData = base64_encode($data);
            $src = "data:{$mime_type};base64,{$imageData}";
            $image = $src;
            // die($pimage);

            $article = new Article;
            $article = new
        } else {
            $image = null;
            DB::table('news')
                ->where('id', $id)
                ->update([
                    'title'       => $new_title,
                    'text'        => $new_text,
                    'image'       => $image,
                    'state'       => $new_state,
                    'updated_at'  => $updated_at,
                ]);
        }
        return "success";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
