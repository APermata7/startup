<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SILKP Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: #f5f5f5;
            border: 1px solid #cccccc;
            border-radius: 10px;
            padding: 40px;
            width: 360px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #000000;
            text-align: center;
        }

        .login-container h1 {
            font-size: 20px;
            margin-bottom: 25px;
            color: #000000;
        }

        .login-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #cccccc;
            border-radius: 8px;
            background-color: #ffffff;
            color: #000000;
        }

        .login-container input::placeholder {
            color: #888888;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background-color: #000000;
            border: none;
            border-radius: 8px;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #333333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Sistem Informasi Laporan Kinerja Pegawai</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>