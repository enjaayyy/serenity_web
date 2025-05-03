@extends('index')

@section('title', 'admin_archives')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/archive.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">Archive</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="search-container">
                <div class="input-container">
                    <img src="{{asset('assets/search-icon.svg') }}">
                    <input type="text" placeholder="Search User" class="search-input"></input>
                    <img src="{{asset('assets/filter-icon.svg') }}">
                </div>
                <p>{{ $archiveCount }}</p>
            </div>
            <table class="table">
                   <thead class="table-head">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Profession</th>
                        <th></th>
                    </tr>
                   </thead>
                   <tbody>
                    @if(empty($details))
                    <tr class="no-users-row">
                        <td colspan="5" class="no-users">No Users Found</td>
                    </tr>
                    @else
                       @foreach($details as $doctors)
                            <tr>
                                <td>{{ $doctors['name'] }}</td>
                                <td>{{ $doctors['email'] }}</td>
                                <td class="table-data-specs">
                                    @if(isset($doctors['specialization']) && is_array($doctors['specialization']))
                                        @foreach($doctors['specialization'] as $spec)
                                            <p>{{$spec}}&nbsp;</p>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $doctors['profession'] }}</td>
                                <td>
                                    <form action="{{ route('activate', $doctors['id']) }}" method="POST">
                                        @csrf
                                        <button class="btn" type="submit">Activate</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                   </tbody>
            </table>
        </div>
        {{-- <script src="{{ asset('js/utilities/search.js') }}"></script> --}}
@endsection