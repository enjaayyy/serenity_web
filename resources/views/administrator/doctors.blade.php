<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/administrator/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/administrator/admindoctor.css') }}">
    </head>
    <body>
        <div class="page-container">
             @include('administrator/adminSidebar')
        <div class="empty"></div>
        <div class="content">
            <p class="header">Doctors</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Specialization</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $doctors)
                    <tr>
                        <td>{{ $doctors['docname'] }}</td>
                        <td>{{ $doctors['docemail'] }}</td>
                        <td>{{ $doctors['docprofession'] }}</td>
                        <td>{{ $doctors['docspecialization'] }}</td>
                        <td>
                            <form action="{{ route('viewdoctor', $doctors['id']) }}" method="GET">
                                <button class="btn" type="submit">view</button>
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