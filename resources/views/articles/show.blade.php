@extends('articles.layouts.app')

@section('content')
    <div class="py-40 space-y-2 xl:space-y-0 w-4/5 sm:w-2/5 mx-auto">
        <h2 class="text-gray-100 pb-4 text-3xl sm:text-5xl font-bold">
            Safe Hands for your bold product plans.
        </h2>

        <span class="py-8 text-white text-sm">
            Code With Dary · 8 March 2023 ·
            <a href="" class="border-b-2 pb-1 border-red-500 hover:text-red-500 transition-all">
                Laravel
            </a>
        </span>

        <div>
            <p class="font-bold text-white text-md pt-10">
                Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
            </p>

            <p class="font-normal text-white text-md pt-4 whitespace-pre-line text-left">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquid beatae delectus dolore fugiat iste molestiae neque non officiis porro quae quas quo repellat sed, velit, voluptatem, voluptatibus! Possimus, totam.

                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad, aliquid corporis eveniet hic necessitatibus nemo nesciunt nihil nulla numquam pariatur repellat sit. Deleniti, natus veritatis. Dolorum maxime molestias nulla quisquam?

                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus, ad assumenda consequatur consequuntur deserunt dolores eum fuga fugiat impedit incidunt inventore iure minima natus nihil rem ullam unde vitae? Maxime.
            </p>

            <ul class="pt-10">
                <li class="inline">
                    <a href=""
                       class="inline bg-red-700 rounded-md py-1 px-2 font-semibold text-sm text-white hover:text-gray-900 dark:text-white dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 mr-4">
                        # laravel
                    </a>
                </li>
            </ul>
        </div>

        <div class="pt-10">
            <div class="border-t-2 border-red-900">
                <h3 class="text-white font-bold pt-10">
                    Laravel
                </h3>
                <p class="text-white font-normal pt-2 text-sm">
                    Laravel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
                </p>
            </div>
        </div>
    </div>
@endsection
