## LARAVEL COMPONENTS
    - How to work with components in Laravel
    - Create a folder called components
            components- Folder      
                master.blade.ph
    
    - Open the welcome.blade.php
            <x-master>
                @section('main-content')
                
                @endsection

                @ssection('side-bar')
                    <div class="card my-4">Search</div>

                    <div class="card my-4">Categories </div>

                    <div class="card my-4"> Side Widget</div>

                @endsection
            </x-master>

    - Devide the parts in master Layouts
            . Blog entries column
            . Side widget column

    - Master file
        <div class="col-md-8">
            @yield('main-content')
        </div>

        <div class="col-md-4">
           @yield('side-bar')
        </div>
    - We want to make search widdgett as component

                <x-master>
                @section('main-content')
                
                @endsection

                @ssection('side-bar')
                   <x-home-search></x-home-search>

                    <x-categories></x-categories>

                    <<x-side-widget></x-side-widget>

                @endsection
            </x-master>
    - Go inside the component folder and create
               components /home-search.blade.php
               components /categories.blade.php
               components /side-widget.blade.php

    

    - Pass data into components    
            <x-categories :variable expecting="value"></x-categories>
            <x-categories :users="$users"></x-categories>

    - Create a User Controller
                public function index()
                {
                    $users = User::all();
                    return view('', compact('users'));
                }
    - Open the component of categories.blade.php
                @foreach($users as $user) 
                    {{ $user->name }}
                @enndforeach
                
            
