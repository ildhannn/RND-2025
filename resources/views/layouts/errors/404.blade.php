@php
$customizerHidden = 'customizer-hide';
$configData = Helper::appClasses();
@endphp

@extends('layouts/blankLayout')

@section('title', 'Error - 404')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-misc.css')}}">
@endsection


@section('content')
<!-- Error -->
<div class="misc-wrapper">
  <h1 class="mb-2 mx-2" style="font-size: 6rem;">404</h1>
  <h4 class="mb-2">Halaman Tidak Ditemukan!</h4>
  <p class="mb-4 mx-2">Kami tidak bisa menemukan halaman yang anda tuju</p>
  <div class="d-flex justify-content-center mt-5">
    <div class="d-flex flex-column align-items-center">
      {{-- <img src="{{ asset('assets/img/error/404.png' )}}" alt="misc-error" class="img-fluid z-1" width="190"> --}}
      <div>
        <a href="{{url('/')}}" class="btn btn-primary text-center my-4">Kembali kehalaman utama</a>
      </div>
    </div>
  </div>
</div>
<!-- /Error -->
@endsection
