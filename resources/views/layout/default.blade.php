<!DOCTYPE html>
    <html lang="en">
     <head>
       @include('layout.partials.head')
       <!-- page specific styles -->
        @yield('pagespecificstyles')
     </head>
     <body>
    @include('layout.partials.nav')
    @yield('content')
    @include('layout.partials.footer')
    @include('layout.partials.footer-scripts')
    <!-- page specific scripts -->
    @yield('pagespecificscripts')
     </body>
    </html>