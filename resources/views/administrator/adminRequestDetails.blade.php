<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/adminrequestdetails.css') }}">
    </head>
    <body>
        @include('administrator/adminSidebar')
        <div class="empty"></div>
        <div class="content">
            <p class="header">Doctor Profile</p>
            <div class="main-info"> 
                <div class="info">      
                    <img src = "{{ asset('assets/avatar.png') }}" class="avatar1">
                    <p class="user-name">{{ $details['name'] }}</p>
                    <p class="prof">{{ $details['profession'] }}</p>
                </div>
                <div class="info2">
                    <div class="detail-header1">
                    <p class="spec-head">Specialization</p>
                    <p class="sex-head">Sex</p>
                    <p class="age-head">Age</p>
                </div>
                <div class="content1">
                    <p class="spec-ctnt">{{ $details['specialization'] }}</p>
                    <p class="gender-ctnt">{{ $details['gender'] }}</p>
                    <p class="age-ctnt">{{ $details['age'] }}</p>
                </div>
                <div class="detail-header2">
                    <p class="address-head">Work Address</p>
                    <p class="med-head">Medical License</p>
                </div>
                <div class="content2">
                    <p class="add-ctnt">{{ $details['address'] }}</p>   
                    <p class="med-ctnt">{{ $details['license'] }}</p>
                </div>          
                    <div class="buttons">
                    <form action = "{{ route('approve', ['id' => $details['id']]) }}" method="POST">
                        @csrf
                           <button class="approve" type="submit" name="approve">Approve</button>
                    </form>
                    <button class="delete">Delete</button>
                </div>
            </div>
        </div>
        <div class="verifiles">
                <p class="sub-header">Credentials</p>
                <div class="files">
                    @if(isset($details['credentials']) && is_array($details['credentials']))
                        @foreach($details['credentials'] as $images)
                     <div class="file-item">
                         <img src="{{ $images }}">
                      </div>
                        @endforeach
                    @else
                      <p>No credentials available.</p>
                  @endif
                </div>
            </div>
            <button class="verify" onclick = "openLink()">Verify</button>

            <script>
                function openLink() {
                    const url = 'https://online.prc.gov.ph/Verification';
                    window.open(url);
                }
            </script>
    </body>
</html>