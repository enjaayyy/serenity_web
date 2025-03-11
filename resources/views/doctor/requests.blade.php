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
        <p>{{ $appointmentCount }}</p>
    </div>
        <table class="table">
                <thead class="table-head">
                    <tr>
                        <th class="name-header">Name</th>
                        <th class="email-header">Email</th>
                        <th>Condition</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @if(empty($patientData))
                        <tr>
                            <td colspan="4" style="text-align: center; color: lightgray; height: 5vh;"> No appointments available. </td>
                        </tr>
                    @else
                        @foreach($patientData as $patient)
                            <tr>
                                <td>{{ $patient['name'] }}</td>
                                <td>{{ $patient['email'] }}</td>
                                <td>
                                    @if(isset($patient['conditions']) && is_array($patient['conditions']))
                                        @foreach($patient['conditions'] as $condition)
                                            <p>{{$condition}}</p>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('patientAction', ['id' => $patient['refId']]) }}">
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
<script src="{{ asset('js/utilities/search.js') }}"></script>
@endsection

