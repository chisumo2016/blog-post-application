<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public  function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

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

        return view('articles.create', $this->getFormData());
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
    public function show(Article $article):View
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article): View
    {
        //array_merge(compact('article'), $this->getFormData());

        return view('articles.edit', array_merge(compact('article'), $this->getFormData()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article):RedirectResponse
    {
       $article->update($request->validated()+ [
            'slug' => Str::slug($request->title)
           ]);

            /**Detach tag*/
        $article->tags()->sync($request->tags);

        return redirect(route('dashboard'))->with('message', 'Article has been updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article):RedirectResponse
    {
        $article->delete();

        return redirect(route('dashboard'))->with('message', 'Article has been deleted Successfully');
    }

    private  function getFormData() : array
    {
        $categories = Category::pluck('name','id');

        $tags = Tag::pluck('name','id');

        return compact('categories', 'tags');
    }
}
