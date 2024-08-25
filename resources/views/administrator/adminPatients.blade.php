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
                    @foreach($details as $doctors)
                        <tr>
                            <td>{{ $doctors['name'] }}</td>
                            <td>{{ $doctors['email'] }}</td>
                            <td>{{ $doctors['number'] }}</td>
                            <td>{{ $doctors['condition'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>