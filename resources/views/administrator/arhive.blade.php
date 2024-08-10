<!DOCTYPE html> 
<html>
    <head>      
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/archive.css') }}">
    </head>
    <body>
        @include('administrator/adminSidebar')
        <div class="empty"></div>
        <div class="content">
            <p class="header">Deactivated Accounts</p>
            <table class="table">
                   <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Specialization</th>
                        <th>Profession</th>
                        <th></th>
                    </tr>
                   </thead>
                   <tbody>
                       @foreach($details as $doctors)
                            <tr>
                                <td>{{ $doctors['name'] }}</td>
                                <td>{{ $doctors['email'] }}</td>
                                <td>{{ $doctors['specialization'] }}</td>
                                <td>{{ $doctors['profession'] }}</td>
                                <td>
                                    <form action="{{ route('activate', $doctors['id']) }}" method="POST">
                                        @csrf
                                        <button class="btn" type="submit">Activate</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                   </tbody>
            </table>
        </div>
        
    </body>
</html>

