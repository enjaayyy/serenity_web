@extends('index')

@section('title', 'patient-requests')

@section('content')
<link rel="stylesheet" href="{{ asset('css/doctor/requests.css') }}">
<div>
    <div class="container">
        <div class="admin-header">
            <p class="dash-text">Patient Requests</p>
            <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
        </div>
        <div class="search-container">
        <div class="input-container">
            <img src="{{asset('assets/search-icon.svg') }}">
            <input type="text" placeholder="Search Patient" class="search-input"></input>
            <img src="{{asset('assets/filter-icon.svg') }}">
        </div>
        <p>Number of Request</p>
    </div>
    <table class="table">
                <thead class="table-head">
                    <tr>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Condition</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($patientData))
                        <tr class="no-users-row">
                            <td colspan="5" class="no-users">No Users Found</td>
                        </tr>
                    @else
                        @foreach($patientData as $patient)
                        <tr>
                            <td>{{ $patient['name'] }}</td>
                            <td>{{ $patient['email'] }}</td>
                            <td>@if(isset($patient['condition']) && is_array($patient['condition']))
                                    @foreach($patient['condition'] as $condition)
                                        {{ $condition }}
                                    @endforeach 
                                @endif
                            </td>
                            <td>{{ $patient['status'] }}</td>
                            <td>
                                <form method="POST" action="{{ route('patientAction', ['id' => $patient['id']]) }}">
                                    @csrf
                                        <button type="submit" name="action" value="accept" class="accept">Accept</button>
                                        <button type="submit" name="action" value="delete" class="del">Delete</button>
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

{{-- <div class="page-container">
             <div class="content">
                <p class="header">Requests</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Email</td>
                                <td>Condition</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patientData as $patient)
                                <tr>
                                    <td>{{ $patient['name'] }}</td>
                                    <td>{{ $patient['email'] }}</td>
                                    <td>
                                        @if(isset($patient['condition']) && is_array($patient['condition']))
                                            @foreach($patient['condition'] as $condition)
                                                {{ $condition }}
                                            @endforeach 
                                        @endif
                                    </td>
                                    <td class="status">{{ $patient['status'] }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('patientAction', ['id' => $patient['id']]) }}">
                                            @csrf
                                            <button type="submit" name="action" value="accept" class="accept">Accept</button>
                                            <button type="submit" name="action" value="delete" class="del">Delete</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
             </div> 
        </div> --}}