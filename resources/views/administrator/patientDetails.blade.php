@extends('index')

@section('title', 'admin-patient-details')

@section('content')
        <link rel="stylesheet" href="{{ asset('css/administrator/patientDetails.css') }}">
            <p class="header">Patient Profile</p>
                <div class="main-content">
                    <div class="left-container">
                        <div class="user-info">
                            <div class="profile-group">
                                <div class="img-container">
                                    <img src="{{ asset('assets/avatar.png') }}" class="profile-img">
                                </div>
                                <div class="profile-group-cntn">
                                    <p class="u-name">{{ $userDetails['name'] }}</p>
                                    <p class="u-email">{{ $userDetails['email'] }}</p>
                                    <p class="u-cond-head">Condition:</p>
                                    <p class="u-cond">
                                        @if(isset($userDetails['condition']) && is_array($userDetails['condition']))
                                            @foreach($userDetails['condition'] as $condition)
                                                {{ $condition }}
                                            @endforeach 
                                        @endif
                                    </p>
                                </div>
                                <div class="divider"> </div>
                                <div class="doc-list-container">
                                    @if(!empty($docData) && is_array($docData))
                                    <div class="doc-list-container">
                                        @foreach($docData as $index)
                                        <form method="GET" action="{{ route('viewdoctor', $index['id']) }}">
                                            @csrf
                                            <button class="doc-list" type="submit">
                                                @if(!empty($index['profile']))
                                                    <img src="{{ $index['profile'] }}">
                                                @else
                                                    <img src="{{ asset('assets/avatar.png') }}">
                                                @endif
                                                    <p class="doctor-name">{{ $index['name'] }}</p>
                                                    @if($index['status'] == 'approved')
                                                    <p class="approved">{{ $index['status'] }}</p>
                                                    @else
                                                    <p class="pending">{{ $index['status'] }}</p>
                                                    @endif
                                            </button><br>
                                        </form>
                                        @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="charts">
                            <p class="act-header">Activity</p>
                            <div id="curve_chart"></div>
                        </div>
                    </div>
                    <div class="right-container">
                        aaaa
                    </div>
                </div>
                <div class="deactivate-btn-container">
                    <form action="{{ route('deactivate', ['id' => $userDetails['id']]) }}" method="POST">
                        @csrf
                            <button class="d-btn" type="submit"><img src="{{ asset('assets/report-icon.svg') }}"><p>Deactivate<p></button>
                    </form>
                </div>
                
@endsection