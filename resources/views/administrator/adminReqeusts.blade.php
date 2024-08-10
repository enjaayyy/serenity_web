<!DOCTYPE html>
<html>      
    <head>
          <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
          <link rel="stylesheet" href="{{ asset('css/requests.css') }}">
          @stack('styles')
    </head>
    <body>
        <div class="page-container">
                @include('administrator/adminSidebar')
                <div class="empty"></div>
            <div class="content">
                <p class="header">Pending Requests</p>
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
                        @foreach ($details as $doctor)
                        <tr>
                            <td>{{ $doctor['name'] }}</td>
                            <td>{{ $doctor['email'] }}</td>
                            <td>{{ $doctor['profession'] }}</td>
                            <td>{{ $doctor['specialization'] }}</td>
                            <td>
                                <form action="{{ route('adminRequestsDetails', $doctor['id']) }}" method="GET">
                                    <button class="btn" type="submit">View</button>
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