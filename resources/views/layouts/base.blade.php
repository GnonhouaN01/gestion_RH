@extends('layouts.app')

@section('content')
  
    <div class="flex h-screen">
        @include('partials.aside')

        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            @include('partials.header')
            @yield('ChildContent')
        </div>
        
    </div>
@endsection
