@extends('frontend.layouts.app')

@section('title',  'Nepal Auto')

@section('keywords',  'Automotive news, Nepal Auto, Auto Price, Nepal, Auto News')
@section('description',  'Leading source for latest Auto News in Nepal. Breaking Auto coverage at your finger tips. Bookmark us and stay up to date with Auto news.')
@section('url',   url('/') )
@section('image',  URL::to('photos/uploads/2017/05/logo.png'))

@section('content')
<style>
        .homebanner{width: 100%; height: auto !important}
    </style>
    <div class="col-sm-9">
		<div class=" row mar-bot-40">
            <div class="col-md-12">
                <img src="{{url('images/750-x-90px_nepal-auto.gif')}}" alt="" class="homebanner" >
            </div>
        </div>

        @include('frontend.includes.slider')

        @include('frontend.includes.price')

        @include('frontend.includes.featured')

        @include('frontend.includes.other')

    </div>
@endsection