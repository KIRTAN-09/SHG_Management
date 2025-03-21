<!DOCTYPE html>  
<html lang="en">  
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Login Form</title>  
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">  
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>  
</head>  
<body>  
    <div class="container" id="container">  
        <div class="form-container">
            <div class="form-box login">  
                <form action="{{ route('login') }}" method="POST" onsubmit="showLoader()">  
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
                    <div class="forgot-link">  
                        <a href="{{ route('password.request') }}">Forgot Password?</a>  
                    </div>  
                    <button type="submit" class="btn"><u>Login</u></button>  
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
            const loader = document.createElement('div');
            loader.className = 'cs-loader';
            loader.innerHTML = `
                <div class="cs-loader-inner">
                    <div class="loader-circle"></div>
                    <div class="loader-circle"></div>
                    <div class="loader-circle"></div>
                    <div class="loader-circle"></div>
                    <div class="loader-circle"></div>
                    <div class="loader-circle"></div>
                </div>
            `;
            document.body.appendChild(loader);
            loader.style.display = 'flex';
            document.querySelector('.container').classList.add('blur-background');
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
            z-index: 1000; /* Ensure it is above other elements */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cs-loader-inner {
            display: flex;
            gap: 10px;
        }

        .loader-circle {
            width: 15px;
            height: 15px;
            background-color: #70bcef;
            border-radius: 50%;
            animation: bounce 0.6s infinite alternate;
        }

        .loader-circle:nth-child(2) {
            animation-delay: 0.1s;
        }

        .loader-circle:nth-child(3) {
            animation-delay: 0.2s;
        }

        .loader-circle:nth-child(4) {
            animation-delay: 0.3s;
        }

        .loader-circle:nth-child(5) {
            animation-delay: 0.4s;
        }

        .loader-circle:nth-child(6) {
            animation-delay: 0.5s;
        }

        @keyframes bounce {
            to {
                transform: translateY(-20px);
                background-color:  darkblue;
            }
        }

        .blur-background {
            filter: blur(5px);
        }
    </style>
</body>  
</html>