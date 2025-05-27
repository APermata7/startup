<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Pengguna</title>
    <style>
        :root {
            --primary-color: #000000;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
            --border-color: #ddd;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }
        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        h1 {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 600;
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 10px;
            margin-bottom: 0;
        }
        .logout-btn {
            background: var(--primary-color);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 22px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .logout-btn:hover {
            background: #333;
        }
        h2 {
            color: var(--primary-color);
            margin-top: 30px;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }
        .form-control {
            flex: 1;
            min-width: 200px;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 16px;
        }
        select.form-control {
            padding-right: 30px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }
        .btn:hover, .btn-primary:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }
        .user-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }
        .user-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .password-note {
            font-size: 0.9rem;
            color: #666;
            margin-top: 5px;
        }
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            .form-control {
                width: 100%;
            }
            .user-actions {
                flex-direction: column;
            }
            .header-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-bar">
            <h1>Admin - Manajemen Pengguna</h1>
            <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <section>
            <h2>Tambah User Baru</h2>
            <form action="{{ route('admin.register') }}" method="POST">
                @csrf
                <div class="form-row">
                    <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                    <input type="email" name="email" class="form-control" placeholder="Alamat Email" required>
                    <select name="role" class="form-control" required>
                        <option value="karyawan">Karyawan</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-row">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            </form>
        </section>

        <section>
            <h2>Daftar Pengguna</h2>
            @foreach($users as $user)
                <div class="user-card">
                    <form action="{{ route('admin.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            <select name="role" class="form-control" required>
                                <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <input type="password" name="password" class="form-control" placeholder="Password baru (kosongkan jika tidak diubah)">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                        </div>
                        <p class="password-note">Biarkan password kosong jika tidak ingin mengubah</p>
                        <div class="user-actions">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                    <form action="{{ route('admin.delete', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')" style="margin-top: 10px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus Pengguna</button>
                    </form>
                </div>
            @endforeach
        </section>
    </div>

    <script>
        // Simple confirmation for delete action (backup, optional)
        document.querySelectorAll('.btn-danger').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>