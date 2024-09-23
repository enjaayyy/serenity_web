<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/administrator/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/administrator/adminPatients.css') }}">
    </head>
    <body>
        @include('administrator.adminSidebar')
        <div class="empty"></div>
        <div class="content">
            <p class="header">Patients</p>
            <table class="table">
                <thead>
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
                                <form method="GET" action="{{ route('viewPatientDetails', $patients['id']) }}">
                                    @csrf
                                    <button class="btn" type="submit">View</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>