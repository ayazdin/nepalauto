@extends('frontend.layouts.app')

@section('title',  'Nepal Auto')

@section('keywords',  'Automotive news, Nepal Auto, Auto Price, Nepal, Auto News')
@section('description',  'Leading source for latest Auto News in Nepal. Breaking Auto coverage at your finger tips. Bookmark us and stay up to date with Auto news.')
@section('url',   url('/') )
@section('image',  URL::to('photos/uploads/2017/05/logo.png'))

@section('content')
    <div class="col-sm-9">
        @include('frontend.includes.slider')

        @include('frontend.includes.price')

        @include('frontend.includes.featured')

        @include('frontend.includes.other')

    </div>
@endsection