@include('layouts.header', [
    'title' => 'Messages', 
    'bodyClass' => 'bg-gray-100 min-h-screen',
    'backUrl' => url()->previous()
])
@yield('content')
@include('layouts.footer')
