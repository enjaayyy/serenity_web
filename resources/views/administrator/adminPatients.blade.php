@extends('index')

@section('title', 'admin_patient_list')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/adminPatients.css') }}">
        <div class="container">
            <div class="admin-header">
                <p class="dash-text">Patients</p>
                <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
            </div>
            <div class="search-container">
                <div class="input-container">
                    <img src="{{asset('assets/search-icon.svg') }}">
                    <input type="text" placeholder="Search Doctor" class="search-input"></input>
                    <img src="{{asset('assets/filter-icon.svg') }}">
                </div>
                <p>Number of Patients</p>
            </div>
            <table class="table">
                <thead class="table-head">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone No.</th>
                        <th>Condition</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($details as $patients)
                        <tr>
                            <td>{{ $patients['name'] }}</td>
                            <td>{{ $patients['email'] }}</td>
                            <td>{{ $patients['number'] }}</td>
                            <td>@if(isset($patients['condition']) && is_array($patients['condition']))
                                    @foreach($patients['condition'] as $condition)
                                        {{ $condition }}
                                    @endforeach 
                                @endif
                            </td>
                            <td>
                                <form class="view-btn" method="GET" action="{{ route('viewPatientDetails', $patients['id']) }}">
                                    @csrf
                                    <button class="btn" type="submit">
                                        <img src="{{ asset('assets/view-icon.svg')}}">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script src="{{ asset('js/utilities/search.js') }}"></script>
@endsection
