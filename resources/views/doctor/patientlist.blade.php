@extends('index')

@section('title', 'doctor-patient-list')

@section('content')
<link rel="stylesheet" href="{{ asset('css/doctor/patientlist.css') }}">
<div>
    <div class="container">
        <div class="admin-header">
            <p class="dash-text">Patients</p>
            <img src="{{asset('assets/logo-w-text.svg') }}" class="page-logo">
        </div>
        <div class="search-container">
        <div class="input-container">
            <img src="{{asset('assets/search-icon.svg') }}">
            <input type="text" placeholder="Search Patient" class="search-input"></input>
            <img src="{{asset('assets/filter-icon.svg') }}">
        </div>
        <p>{{ $patientCount }}</p>
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
                    @if(empty($patientData))
                        <tr class="no-users-row">
                            <td colspan="5" class="no-users">No Users Found</td>
                        </tr>
                    @else
                        @foreach($patientData as $patient)
                        <tr>
                            <td>{{ $patient['name'] }}</td>
                            <td>{{ $patient['email'] }}</td>
                            <td>{{ $patient['phone'] }}</td>
                            <td class="table-data-specs">
                                @if(isset($patient['conditions']) && is_array($patient['conditions']))
                                    @foreach($patient['conditions'] as $condition)
                                        <p>{{ $condition }}&nbsp;</p>
                                    @endforeach 
                                @endif
                            </td>
                            <td>
                                <form class="view-btn" method="GET" action="{{ route('patientProfile', ['id' => $patient['id']]) }}">
                                    @csrf
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
        <script src="{{ asset('js/utilities/search.js') }}"></script>
        {{-- <script>
            var patientData = <?php echo json_encode($patientData, JSON_PRETTY_PRINT); ?>;
                console.log(patientData);
        </script> --}}
@endsection