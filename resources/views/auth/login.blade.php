<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login Form</title>  
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">  
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>  
</head>  
<body>  
    <div class="cs-loader">
        <div class="cs-loader-inner">
            <label>●</label>
            <label>●</label>
            <label>●</label>
            <label>●</label>
            <label>●</label>
            <label>●</label>
        </div>
    </div>
    <div class="container" id="container">  
        <div class="form-container">
            <div class="form-box login">  
                <form action="{{ route('login') }}" method="POST">  
                    @csrf
                    <h1><u><b>Login</b></u></h1>  
                    <div class="input-box">  
                        <input type="text" name="login" placeholder="Email or Username" required>  
                        <i class='bx bxs-user'></i>  
                    </div>  
                    <div class="input-box">  
                        <input type="password" name="password" placeholder="Password" required>  
                        <i class='bx bx-show password-toggle' onclick="togglePassword()"></i> <!-- Add show password icon -->
                    </div>  
                    <!-- <div class="forgot-link">  
                        <a href="{{ route('password.request') }}">Forgot Password?</a>  
                    </div>   -->
                    <button type="submit" class="btn" onclick="showLoader()"><u>Login</u></button>  
                </form>  
            </div>  
            <div class="form-box register">  
                <br><br>
                <div class="left-section">
                    <img src="{{ asset('images/df_logo2.png') }}" alt="Logo">
                    <br>
                    <h2><u>Deep Jyot Mahila <br> Co. Operative Credit<br> Society Limited.</u></h2>
                </div>
                    
                </form>  
            </div>  
        </div>
        <div class="toggle-box"> 
            <div class="toggle-panel toggle-left">  
                <h1><u>Welcome Back!</u></h1> 
                <br><br><br><br><br>
                <button class="btn login-btn"> ---> </button> 
            </div>  
            <div class="toggle-panel toggle-right"> 
                <h1><u>Hello, Welcome!</u></h1>  
                 <br><br><br><br><br>
                <button class="btn register-btn"><u>Login</u></button>  
            </div>  
        </div>  
    </div>  
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const passwordToggle = document.querySelector('.password-toggle');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordToggle.classList.replace('bx-show', 'bx-hide');
            } else {
                passwordInput.type = 'password';
                passwordToggle.classList.replace('bx-hide', 'bx-show');
            }
        }

        function showLoader() {
            document.querySelector('.cs-loader').style.display = 'flex';
        }
    </script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #70bcef;
            transition: background 3s ease-in-out; /* Ensure smooth transition */
        }

        .cs-loader {
            display: none; /* Initially hide the loader */
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: #70bcef;
            opacity: 0.8;
            z-index: 1000; /* Ensure it is above other elements */
        }

        .cs-loader-inner {
            transform: translateY(-50%);
            top: 50%;
            position: absolute;
            width: 100%;
            color: black;
            padding: 0 100px;
            text-align: center;
        }

        .cs-loader-inner label {
            font-size: 20px;
            opacity: 0;
            display: inline-block;
        }

        @keyframes lol {
            0% {
                opacity: 0;
                transform: translateX(-300px);
            }
            33% {
                opacity: 1;
                transform: translateX(0px);
            }
            66% {
                opacity: 1;
                transform: translateX(0px);
            }
            100% {
                opacity: 0;
                transform: translateX(300px);
            }
        }

        @-webkit-keyframes lol {
            0% {
                opacity: 0;
                -webkit-transform: translateX(-300px);
            }
            33% {
                opacity: 1;
                -webkit-transform: translateX(0px);
            }
            66% {
                opacity: 1;
                -webkit-transform: translateX(0px);
            }
            100% {
                opacity: 0;
                -webkit-transform: translateX(300px);
            }
        }

        .cs-loader-inner label:nth-child(6) {
            -webkit-animation: lol 3s infinite ease-in-out;
            animation: lol 3s infinite ease-in-out;
        }

        .cs-loader-inner label:nth-child(5) {
            -webkit-animation: lol 3s 100ms infinite ease-in-out;
            animation: lol 3s 100ms infinite ease-in-out;
        }

        .cs-loader-inner label:nth-child(4) {
            -webkit-animation: lol 3s 200ms infinite ease-in-out;
            animation: lol 3s 200ms infinite ease-in-out;
        }

        .cs-loader-inner label:nth-child(3) {
            -webkit-animation: lol 3s 300ms infinite ease-in-out;
            animation: lol 3s 300ms infinite ease-in-out;
        }

        .cs-loader-inner label:nth-child(2) {
            -webkit-animation: lol 3s 400ms infinite ease-in-out;
            animation: lol 3s 400ms infinite ease-in-out;
        }

        .cs-loader-inner label:nth-child(1) {
            -webkit-animation: lol 3s 500ms infinite ease-in-out;
            animation: lol 3s 500ms infinite ease-in-out;
        }
    </style>
</body>  
</html>