<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/doctor/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/patientlist.css') }}">
    </head>
    <body>
        <div class="page-container">
            @include('doctor.sidebar')
            <div class="empty"></div>
            <div class="content">
                <p class="header">My Patients</p>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Condition</th>
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
                                <td>
                                    <form method="GET" action="{{ route('patientProfile', $patient['userID']) }}">
                                        @csrf
                                        <button type="submit" class="view">View</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </body>
</html>