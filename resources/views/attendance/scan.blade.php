@extends('layouts.app')

@section('header')
<h1 class="text-lg font-bold text-slate-800">Absen Mentor</h1>
@endsection

@section('content')
    @include('attendance._scanner')
@endsection
