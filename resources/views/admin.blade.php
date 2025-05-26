<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manajemen Pengguna</title>
    <style>
        body {
            background-color: #fff;
            color: #000;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
        }
        h1, h2 {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 20px;
        }
        form {
            background-color: #fff;
            border: 2px solid #000;
            padding: 20px;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 24px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #000;
            background-color: #fff;
            color: #000;
        }
        button {
            cursor: pointer;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
        }
        button:hover {
            background-color: #fff;
            color: #000;
            border: 1px solid #000;
        }
        hr {
            border: 1px dashed #000;
        }
        p {
            font-weight: bold;
        }
        .register-button {
            background-color: #000;
            color: #fff;
            padding: 10px 16px;
            border: none;
            margin-top: 10px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
            justify-content: flex-start;
        }
        .button-group button {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 8px 16px;
            min-width: 100px;
        }
    </style>
</head>
<body>
    <h1>Admin - Manajemen Pengguna</h1>
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <h2>Tambah User Baru</h2>
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
        <button type="submit" class="register-button">Register User</button>
    </form>

    <h2>Daftar User</h2>
    @foreach($users as $user)
        <form action="{{ route('admin.update', $user->id) }}" method="POST" class="user-form">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $user->name }}" required>
            <input type="email" name="email" value="{{ $user->email }}" required>
            <input type="password" name="password" placeholder="Password baru (opsional)">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi password">
            <div class="button-group">
                <form action="{{ route('admin.delete', $user->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')" style="margin:0; padding:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Hapus</button>
                </form>
                <button type="submit">Simpan</button>
            </div>
        </form>
        <hr>
    @endforeach
</body>
</html>
