@extends('layout') 

@section('content')
@include('partial._hero')  
@include('partial._search')  

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
    @foreach ($listings as $item)
            <x-listing-card :item="$item" />
        @endforeach
</div>
    <div class="mt-6 p-4">
        {{$listings->links()}}
    </div>
@endsection
