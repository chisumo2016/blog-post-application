<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() :View
    {
       $articles = Article::with(['user', 'tags'])->latest()->simplePaginate();

       return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() :View
    {
        $categories = Category::pluck('name','id');

        $tags = Tag::pluck('name','id');

        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create([
            'slug'          => Str::slug($request->title),
            'status'        => $request->status === 'on'  ,
            'user_id'       => auth()->id(),
        ]+$request->validated());

        /** Handle Pivot Table */

        $article->tags()->attach($request->tags);

        return redirect(route('articles.index'))->with('message', 'Article has been created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {

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
