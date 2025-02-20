<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class = "login-container">
        <div class= "login-art-body">  
            <div class="background-overlay"></div>
            <a href ="{{ route('home') }}" style = "text-decoration: none;">
                <img src="{{asset('assets/logo-w-text.svg') }}" class="login-logo">
            </a>
            <p class="login-art-header">Access Your Serenity Account Here</p>
            <p class="login-art-subheader">Become part of a community dedicated to well-being.</p>
        </div>

        <div class = "login-body">
            <p class="header">LOGIN</p>
                <form id="loginform">
                    <p class="email"> Email </p>
                    <input type="text" class = "email-input" name="email" id="email" placeholder="Enter Email Address" required>
                    <p class="password"> Password </p>
                    <input type="password" class = "password-input" name="pass" id="pass" placeholder="Password" required><br><br>
                </form>
                    <button class = "login-btn" onclick="login()"> Login </button>
                <br>
                <p class = "prompt">Don't have an account? <a href = "{{ route('register') }}" style= "color: blue;" >Click here!</a></p>
        </div>
        <div class="login-status-container" id="login-status-container" style="display: none;">
            <div class="login-status"> 
                <div class="status-logo" id="status-logo">
                    <img id="status-logo-img">
                </div>
                <div class="status-message-container" id="status-message-container"></div>
                <div class="status-btn-container" id="status-btn-container">
                    <button class="status-button" id="status-button">Proceed</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function login(){
            let emailInput = document.getElementById('email').value;
            let passInput = document.getElementById('pass').value;
            fetch('/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    email: emailInput,
                    pass: passInput 
                }),
            })
            .then(response => response.json())
            .then(data => {
                confirmationLoginModal(data.message, data.redirect, data.status);
            })
        }

        function confirmationLoginModal(message, redirect, status){
            let statusContainer = document.getElementById('login-status-container');
                statusContainer.style.display = "block";
                
                let logoContainer = document.getElementById('status-logo');
                let img = document.getElementById('status-logo-img');

                let statusMessContainer = document.getElementById('status-message-container');
                let statusmessage = document.createElement('p');
                let subMessage = document.createElement('p');

                let statusButtonContainer = document.getElementById('status-btn-container');
                let statusButton = document.getElementById('status-button');

                logoContainer.innerHTML = " ";
                statusMessContainer.innerHTML = " ";
                if(status === "success"){
                    logoContainer.style.backgroundColor = "rgba(32, 192, 115, 0.5)";
                    img.src = "{{ asset('assets/check-circle.svg') }}";
                    statusmessage.textContent = message;
                    statusmessage.classList.add('stat-mess-accepted');
                    subMessage.textContent = "Thank you for actively choosing Serenity."
                    subMessage.classList.add('sub-message');
                    statusButton.type = "submit";
                    statusButton.onclick = function(){
                        window.location.href = redirect;
                    }
                }
                else{
                    logoContainer.style.backgroundColor = "rgba(255, 0, 0, 0.5)";
                    img.src = "{{ asset('assets/block-circle.svg') }}";
                    statusmessage.textContent = message;
                    statusmessage.classList.add('stat-mess-not-accepted');
                    subMessage.textContent = "Please write the correct information details."
                    subMessage.classList.add('sub-message');
                    statusButton.type = "button";
                    statusButton.onclick = function(){
                        statusContainer.style.display = "none";
                    }
                }
                    logoContainer.appendChild(img);
                    statusMessContainer.appendChild(statusmessage);
                    statusMessContainer.appendChild(subMessage);
                    statusButtonContainer.appendChild(statusButton);
        }    
        </script>
</body>
</html>