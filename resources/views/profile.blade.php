<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profil Saya</title>
  <style>
    :root {
      --bg-color: #f5f5f5;
      --card-color: #ffffff;
      --text-color: #333333;
      --border-color: #e0e0e0;
      --primary-color: #000000;
      --secondary-color: #666666;
      --button-bg: #000000;
      --button-text: #ffffff;
      --button-hover: #ffffff;
      --navbar-bg: #000000;
      --navbar-text: #ffffff;
      --navbar-hover: #ffffff;
      --navbar-active-bg: #ffffff;
      --navbar-active-text: #000000;
      --rating-baik: #4CAF50;
      --rating-sedang: #FFC107;
      --rating-buruk: #F44336;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      margin: 0;
      padding: 0;
    }

    .navbar {
      background-color: var(--navbar-bg);
      color: var(--navbar-text);
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
      font-size: 20px;
      font-weight: 600;
      color: var(--navbar-text);
      text-decoration: none;
      margin-right: auto;
      padding-left: 20px;
    }

    .navbar-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .nav-btn {
      background-color: transparent;
      color: var(--navbar-text);
      border: none;
      padding: 8px 16px;
      cursor: pointer;
      font-weight: 600;
      text-decoration: none;
      font-size: 15px;
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .nav-btn:hover {
      background-color: var(--navbar-hover);
      color: var(--primary-color);
      font-size: 15px;
    }

    .nav-btn.active {
        position: relative;
        font-size: 15px;
    }

    .nav-btn.active::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -5px;
        width: 100%;
        height: 3px;
        background-color: white;
        border-radius: 2px;
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      padding: 0 20px;
    }

    .profile-card {
      background-color: var(--card-color);
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    .profile-header {
      margin-bottom: 30px;
      text-align: center;
    }

    .profile-name {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 5px;
    }

    .profile-email {
      color: var(--secondary-color);
      font-size: 16px;
    }

    .profile-section {
      margin-bottom: 30px;
    }

    .section-title {
      font-size: 18px;
      font-weight: 500;
      margin-top: 40px;
      margin-bottom: 15px;
      border-bottom: 1px solid #eee;
      padding-bottom: 8px;
    }

    .info-item {
      margin-bottom: 10px;
      display: flex;
    }

    .info-label {
      font-weight: 500;
      width: 120px;
      color: #555;
    }

    .info-value {
      flex: 1;
    }

    .no-data {
      color: #999;
      font-style: italic;
    }

    .review-list {
      margin: 0;
      padding: 0;
      list-style: none;
    }

    .review-item {
      border-bottom: 1px dashed #eee;
      padding: 10px 0;
    }

    .review-item:last-child {
      border-bottom: none;
    }

    .review-meta {
      font-size: 13px;
      color: #888;
      margin-bottom: 3px;
    }

    .rating-baik { color: var(--rating-baik);}
    .rating-sedang { color: var(--rating-sedang);}
    .rating-buruk { color: var(--rating-buruk);}
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
    <div class="navbar-actions">
      <a
        href="{{ route('profile') }}"
        class="nav-btn {{ Request::is('profile') ? 'active' : '' }}"
      >Profil Saya</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="nav-btn">Logout</button>
      </form>
    </div>
  </nav>

  <div class="container">
    <div class="profile-card">
      <div class="profile-header">
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-email">{{ $user->email }}</p>
      </div>

      <div class="profile-section">
        <h2 class="section-title">Informasi Akun</h2>
        <div class="info-item">
          <span class="info-label">Role:</span>
          <span class="info-value">{{ $user->role }}</span>
        </div>
        <div class="info-item">
          <span class="info-label">Bergabung:</span>
          <span class="info-value">{{ $user->created_at->format('d M Y') }}</span>
        </div>
      </div>

      <div class="profile-section">
        <h2 class="section-title">Review yang Diterima dari Kolega</h2>
        @if($reviewsReceived->count() > 0)
          <ul class="review-list">
            @foreach($reviewsReceived as $review)
              <li class="review-item">
                <div class="review-meta">
                  Dari: {{ $review->penilai->name }} ({{ $review->created_at->format('d M Y') }})
                  <span class="rating-{{ $review->rating }}">| Rating: {{ ucfirst($review->rating) }}</span>
                </div>
                @if($review->review)
                  <div>"{{ $review->review }}"</div>
                @else
                  <div class="no-data">Tidak ada review tertulis.</div>
                @endif
              </li>
            @endforeach
          </ul>
        @else
          <div class="no-data">Belum ada review dari kolega.</div>
        @endif
      </div>
    </div>
  </div>
</body>
</html>