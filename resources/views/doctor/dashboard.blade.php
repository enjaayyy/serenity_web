@extends('index')

@section('title', 'Doctor Dashboard')

@section('content')
        {{-- <link rel="stylesheet" href="{{ asset('css/doctor/dashboard.css') }}"> --}}
        <div class="container">
            <div class="empty"> </div>
            <div class="dash-content">
                Next Update :>
            </div>
            <form method="POST" action=" {{ route('sampleData')}} ">
                @csrf
                <button>Sample questions</button>
            </form>
        </div>
 @endsection