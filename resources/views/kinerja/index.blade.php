<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Kinerja</title>
</head>
<body>
    <h1>Manajemen Kinerja User</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @foreach($users as $user)
        <h3>{{ $user->name }} ({{ $user->email }})</h3>

        <form action="{{ route('kinerja.storeOrUpdate', $user->id) }}" method="POST" style="margin-bottom: 30px;">
            @csrf
            <textarea name="review" placeholder="Tulis review">{{ $user->kinerja->review ?? '' }}</textarea><br>
            <select name="rating" required>
                <option value="baik" {{ (isset($user->kinerja) && $user->kinerja->rating == 'baik') ? 'selected' : '' }}>Baik</option>
                <option value="sedang" {{ (isset($user->kinerja) && $user->kinerja->rating == 'sedang') ? 'selected' : '' }}>Sedang</option>
                <option value="buruk" {{ (isset($user->kinerja) && $user->kinerja->rating == 'buruk') ? 'selected' : '' }}>Buruk</option>
            </select><br>
            <button type="submit">Simpan Kinerja</button>
        </form>
        <hr>
    @endforeach
</body>
</html>
