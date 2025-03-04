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
    <div class="loader" id="loader">
        <div class="loader-text" id="loader-text">Loading...</div>
    </div> <!-- Add loader element -->
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
            const loaderText = document.getElementById('loader-text');
            document.getElementById('loader').style.display = 'flex';
            document.getElementById('container').classList.add('blurred');
            loaderText.innerHTML = loaderText.textContent.split('').map((char, index) => 
                `<span style="animation-delay: ${index * 0.1}s">${char}</span>`
            ).join('');
        }
    </script>
    <style>
        .loader {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #7494ec;
            opacity: 0.8;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-text {
            font-size: 1.5em;
            color: black;
            font-weight: bold;
            display: flex;
        }

        .loader-text span {
            display: inline-block;
            animation: jump 1s infinite;
        }

        .blurred {
            filter: blur(5px);
            pointer-events: none;
        }

        @keyframes jump {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</body>  
</html>