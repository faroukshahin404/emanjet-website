<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>inote</title>
    <link rel="stylesheet" href="./style.css" />
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@100..900&display=swap");

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            width: 100vw;
            height: 100vh;
            display: flex;
            font-family: "Noto Sans Arabic", sans-serif;
        }

        .login-container,
        .hello-msg {
            height: 100%;
        }

        .login-container {
            width: 60%;
        }

        #logo {
            display: block;
            width: 300px;
            padding: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            gap: 0.5rem;
        }

        form h1 {
            color: #cda101;
        }

        .input-container {
            width: 80%;
            background-color: #eaeeed;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.25rem 0.5rem;
        }

        .input-container svg {
            width: 30px;
            margin-top: 8px;
        }

        .input-container input {
            height: 100%;
            width: 95%;
            font-size: 16px;
            background-color: transparent;
            border: none;
            outline: none;
        }

        form a {
            text-decoration: none;
            color: #000;
            font-weight: 500;
            margin: 1rem 0;
        }

        form a:hover {
            text-decoration: underline;
        }

        form button {
            font-family: "Noto Sans Arabic", sans-serif;
            font-weight: 600;
            padding: 0.25rem 2rem;
            border-radius: 2.5rem;
            background-color: #cda101;
            color: #fff;
            font-size: 20px;
            border: none;
            outline: none;
            cursor: pointer;
            transition: all 200ms;
        }

        form button:hover {
            transform: translateY(-4px);
            opacity: 0.9;
        }

        .hello-msg {
            width: 40%;
            background: radial-gradient(#cda101, #cda101);
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #fff;
        }

        .hello-msg svg {
            position: absolute;
            right: 10%;
            bottom: 5px;
        }

        @media (max-width: 720px) {
            .hello-msg {
                display: none;
            }

            .login-container {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            form {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{asset('assets/images/logo.png')}}" alt="" id="logo" />
        <form method="POST" action="{{route('admin.login.submit')}}">
            @csrf
            <h1>تسجيل الدخول</h1>

            @if ($errors->any())
            <div style="color: red; text-align: center; margin-bottom: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="input-container">
                <label for="email">
                    <svg width="36" height="36" viewBox="0 0 36 36" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.3">
                            <path
                                d="M32 6H4C3.46957 6 2.96086 6.21071 2.58579 6.58579C2.21071 6.96086 2 7.46957 2 8V28C2 28.5304 2.21071 29.0391 2.58579 29.4142C2.96086 29.7893 3.46957 30 4 30H32C32.5304 30 33.0391 29.7893 33.4142 29.4142C33.7893 29.0391 34 28.5304 34 28V8C34 7.46957 33.7893 6.96086 33.4142 6.58579C33.0391 6.21071 32.5304 6 32 6ZM30.46 28H5.66L12.66 20.76L11.22 19.37L4 26.84V9.52L16.43 21.89C16.8047 22.2625 17.3116 22.4716 17.84 22.4716C18.3684 22.4716 18.8753 22.2625 19.25 21.89L32 9.21V26.71L24.64 19.35L23.23 20.76L30.46 28ZM5.31 8H30.38L17.84 20.47L5.31 8Z"
                                fill="black" />
                        </g>
                    </svg>
                </label>
                <input type="text" name="email" id="email" placeholder="Email" />
            </div>

            <div class="input-container">
                <label for="password">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.3">
                            <path
                                d="M20 6.11111C16.1708 6.11111 13.0555 9.22639 13.0555 13.0556V15.8333H11.6666C10.1347 15.8333 8.88885 17.0792 8.88885 18.6111V31.1111C8.88885 32.6431 10.1347 33.8889 11.6666 33.8889H28.3333C29.8652 33.8889 31.1111 32.6431 31.1111 31.1111V18.6111C31.1111 17.0792 29.8652 15.8333 28.3333 15.8333H26.9444V13.0556C26.9444 9.22639 23.8291 6.11111 20 6.11111ZM15.8333 13.0556C15.8333 10.7583 17.7027 8.88889 20 8.88889C22.2972 8.88889 24.1666 10.7583 24.1666 13.0556V15.8333H15.8333V13.0556ZM28.3361 31.1111H21.3889V27.9472C22.2152 27.4653 22.7777 26.5792 22.7777 25.5556C22.7777 24.0236 21.5319 22.7778 20 22.7778C18.468 22.7778 17.2222 24.0236 17.2222 25.5556C17.2222 26.5778 17.7847 27.4653 18.6111 27.9472V31.1111H11.6666V18.6111H28.3333L28.3361 31.1111Z"
                                fill="black" />
                        </g>
                    </svg>
                </label>
                <input type="password" name="password" id="password" placeholder="Password" />
            </div>

            <a href="">تواصل بالدعم</a>

            <button type="submit">تسجيل دخول</button>
        </form>
    </div>

    <div class="hello-msg">
        <h1>مرحبا بك</h1>
        <p>نتمني لك يوما سعيدا مليئا بالنشاط والحماس</p>

        <svg width="143" height="164" viewBox="0 0 143 164" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.2" d="M142.165 163.72L0.555166 81.9616L142.165 0.203191L142.165 163.72Z" fill="#B27764" />
        </svg>
    </div>
</body>

</html>
