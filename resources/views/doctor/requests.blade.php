<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/doctor/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/doctor/requests.css') }}">
    </head>
    <body>
        <div class="page-container">
             @include('doctor.sidebar')
             <div class="empty"></div>
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
                                    <td>{{ $patient['condition'] }}</td>
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
              
        </div>
    </body>
</html>