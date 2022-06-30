<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('web.layouts.links')
        <title>{{isset($title)?$title:'Weed Entertainment'}}</title>
    </head>
    <body>
        <!-- Header Start -->
        <header>
            @include('web.layouts.header')
        </header>
        

        @yield('content')
        
        
        <footer>
            @include('web.layouts.footer')
        </footer>
        
        @include('web.layouts.scripts')
        @yield('js')
    </body>
</html>

