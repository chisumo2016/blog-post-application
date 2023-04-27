@extends('article.layouts.app')

@section('content')
    <div class="w-full mx-auto mb-10">
       <span class="block inline text-md text-white transition-all hover:text-gray-100 font-bold uppercase">
           <a href="/" class="bg-red-700 rounded-md py-3 px-5">
                Create Article
           </a>
      </span>
    </div>

    <div class="space-y-2 xl:items-baseline xl:space-y-0 w-4/5 pt-20 sm:w-3/5 mx-auto">
        <div class="border-b-2 border-neutral-700 pb-10 pt-10">
            <span class="sm:float-right float-left text-gray-400">
                8 March 2023, by Code With Dary
            </span>

            <a href="">
                <h2 class="hover:text-red-700 sm:w-3/5 transition-all text-white sm:pt-0 pt-10 text-3xl sm:text-4xl font-bold sm:pb-2 w-full block">
                    Safe Hands for your bold product plans.
                </h2>
            </a>

            <p class="text-gray-400 leading-8 py-6 text-lg w-full sm:w-3/5">
                Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
            </p>

            <span class="block inline text-xs text-white transition-all hover:text-gray-100 font-bold pr-2 uppercase">
            <a href="/" class="bg-red-700 rounded-md py-1 px-3">
                Laravel
            </a>
            </span>
        </div>
    </div>
@endsection
