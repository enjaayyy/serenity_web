@extends('index')

@section('title', 'admin_doctor_view')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/admindoctor.css') }}">
        <div>
            <div class="container">
                <div class="admin-header">
                        <p class="dash-text">Doctors</p>
                        <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
                </div>
                <div class="search-container">
                    <div class="input-container">
                        <img src="{{asset('assets/search-icon.svg') }}">
                        <input type="text" placeholder="Search Doctor" class="search-input"></input>
                        <img src="{{asset('assets/filter-icon.svg') }}">
                    </div>
                    <p>Number of Doctors</p>
                </div>
                <table class="table">
                    <thead class="table-head">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profession</th>
                            <th>Specialization</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(empty($details))
                            <tr class="no-users-row">
                                <td colspan="5" class="no-users">No Users Found</td>
                            </tr>
                        @else
                            @foreach ($details as $doctors)
                                <tr>
                                        <td>{{ $doctors['docname'] }}</td>
                                        <td>{{ $doctors['docemail'] }}</td>
                                        <td>{{ $doctors['docprofession'] }}</td>
                                        <td>{{ $doctors['docspecialization'] }}</td>
                                        <td >
                                            <form class="view-btn" action="{{ route('viewdoctor', $doctors['id']) }}" method="GET">
                                                <button class="btn" type="submit">
                                                    <img src="{{ asset('assets/view-icon.svg')}}">
                                                </button>
                                            </form>
                                        </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <script src="{{ asset('js/utilities/search.js') }}"></script>
@endsection