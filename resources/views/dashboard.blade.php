<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
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

        /* Navbar Styles - Sama dengan profile.blade.php */
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
        }

        .nav-btn.active {
            position: relative;
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

        /* Dashboard Specific Styles */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-title {
            margin-bottom: 30px;
            font-size: 24px;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .user-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            min-height: 250px;
            height: auto;
            position: relative;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .user-email {
            color: var(--secondary-color);
            font-size: 14px;
            margin-bottom: 5px;
        }

        .user-role {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .rating-display {
            font-weight: 500;
            margin-bottom: 10px;
        }

        .rating-baik { color: var(--rating-baik); }
        .rating-sedang { color: var(--rating-sedang); }
        .rating-buruk { color: var(--rating-buruk); }

        .review-display {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
            color: var(--secondary-color);
            flex-grow: 1;
            overflow: hidden;
            position: relative;
        }

        .review-text {
            font-style: italic;
            margin-bottom: 5px;
        }

        .review-meta {
            font-size: 12px;
            color: #999;
        }

        .review-form-container {
            position: relative;
        }

        .review-form {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            padding: 20px;
            z-index: 10;
            display: none;
            width: 90%;
            max-width: 500px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            font-size: 14px;
        }

        select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: inherit;
            box-sizing: border-box;
        }

        textarea {
            min-height: 80px;
            resize: vertical;
            margin-right: 5px;
        }

        .submit-btn {
            background-color: var(--button-bg);
            color: var(--button-text);
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: var(--button-hover);
        }

        .edit-btn {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--border-color);
            padding: 6px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.3s;
            align-self: flex-start;
        }

        .edit-btn:hover {
            background-color: #f5f5f5;
        }

        .no-review {
            color: #999;
            font-style: italic;
            font-size: 14px;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 5;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .alert {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .reviews-list {
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .review-item {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
        }

        .review-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar - Sama persis dengan profile.blade.php -->
    <nav class="navbar">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
        <div class="navbar-actions">
            <a href="{{ route('profile') }}" 
               class="nav-btn {{ Request::is('profile') ? 'active' : '' }}">
               Profil Saya
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h2 class="page-title">Kelola Kinerja Karyawan</h2>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
        @endif

        <div class="users-grid">
            @foreach ($karyawanList as $karyawan)
                <div class="review-form-container">
                    <div class="user-card" id="user-card-{{ $karyawan->id }}">
                        <div class="user-name">{{ $karyawan->name }}</div>
                        <div class="user-email">{{ $karyawan->email }}</div>
                        <div class="user-role">{{ $karyawan->role }}</div>
                        
                        @php
                            $existingReview = $karyawan->reviewsReceived->where('penilai_id', Auth::id())->first();
                        @endphp
                        
                        @if($existingReview)
                            <div class="rating-display">
                                Rating Anda: 
                                <span class="rating-{{ $existingReview->rating }}">
                                    {{ ucfirst($existingReview->rating) }}
                                </span>
                            </div>
                            <div class="review-display">
                                <div class="review-text">"{{ $existingReview->review ?? 'Tidak ada review' }}"</div>
                                <div class="review-meta">Diberikan pada {{ $existingReview->created_at->format('d M Y') }}</div>
                            </div>
                        @else
                            <div class="rating-display">
                                Anda belum memberikan rating
                            </div>
                            <div class="review-display">
                                <span class="no-review">Anda belum memberikan review</span>
                            </div>
                        @endif
                        
                        @if(Auth::id() != $karyawan->id)
                            <button class="edit-btn" onclick="toggleReviewForm({{ $karyawan->id }}, {{ $existingReview ? $existingReview->id : 'null' }})">
                                {{ $existingReview ? 'Edit Review' : 'Beri Review' }}
                            </button>
                        @endif

                        <!-- Reviews from others -->
                        @if($karyawan->reviewsReceived->where('penilai_id', '!=', Auth::id())->count() > 0)
                            <div class="reviews-list">
                                <strong>Review dari kolega:</strong>
                                @foreach($karyawan->reviewsReceived->where('penilai_id', '!=', Auth::id()) as $review)
                                    <div class="review-item">
                                        <div class="rating-{{ $review->rating }}">
                                            {{ ucfirst($review->rating) }}
                                        </div>
                                        @if($review->review)
                                            <div class="review-text">"{{ $review->review }}"</div>
                                        @endif
                                        <div class="review-meta">
                                            Oleh: {{ $review->penilai->name }} ({{ $review->created_at->format('d M Y') }})
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if(Auth::id() != $karyawan->id)
                    <div class="review-form" id="review-form-{{ $karyawan->id }}">
                        @if($existingReview)
                            <!-- Form Edit -->
                            <form method="POST" action="{{ route('review.update', ['review' => $existingReview->id]) }}" id="edit-form-{{ $karyawan->id }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="karyawan_id" value="{{ $karyawan->id }}">
                                <div class="form-group">
                                    <label for="rating-{{ $karyawan->id }}">Rating</label>
                                    <select name="rating" id="rating-{{ $karyawan->id }}" required>
                                        <option value="">Pilih Rating</option>
                                        <option value="baik" {{ old('rating', $existingReview->rating) == 'baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="sedang" {{ old('rating', $existingReview->rating) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="buruk" {{ old('rating', $existingReview->rating) == 'buruk' ? 'selected' : '' }}>Buruk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="review-{{ $karyawan->id }}">Review</label>
                                    <textarea name="review" id="review-{{ $karyawan->id }}">{{ old('review', $existingReview->review) }}</textarea>
                                </div>
                                <div class="button-group">
                                    <button type="submit" class="submit-btn">Update Review</button>
                                    <button type="button" class="edit-btn" onclick="toggleReviewForm({{ $karyawan->id }}, {{ $existingReview->id }})">Batal</button>
                                </div>
                            </form>
                        @else
                            <!-- Form Create -->
                            <form method="POST" action="{{ route('review.store', ['karyawan' => $karyawan->id]) }}" id="create-form-{{ $karyawan->id }}">
                                @csrf
                                <div class="form-group">
                                    <label for="rating-{{ $karyawan->id }}">Rating</label>
                                    <select name="rating" id="rating-{{ $karyawan->id }}" required>
                                        <option value="">Pilih Rating</option>
                                        <option value="baik">Baik</option>
                                        <option value="sedang">Sedang</option>
                                        <option value="buruk">Buruk</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="review-{{ $karyawan->id }}">Review (opsional)</label>
                                    <textarea name="review" id="review-{{ $karyawan->id }}"></textarea>
                                </div>
                                <div class="button-group">
                                    <button type="submit" class="submit-btn">Simpan Review</button>
                                    <button type="button" class="edit-btn" onclick="toggleReviewForm({{ $karyawan->id }}, null)">Batal</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <script>
        function toggleReviewForm(userId, reviewId = null) {
            const form = document.getElementById(`review-form-${userId}`);
            const overlay = document.getElementById('overlay');
            
            if (form.style.display === 'block') {
                form.style.display = 'none';
                overlay.style.display = 'none';
            } else {
                document.querySelectorAll('.review-form').forEach(f => {
                    f.style.display = 'none';
                });
                form.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

        document.getElementById('overlay').addEventListener('click', function() {
            document.querySelectorAll('.review-form').forEach(f => {
                f.style.display = 'none';
            });
            this.style.display = 'none';
        });

        // Handle form submission for both create and edit
        document.querySelectorAll('.review-form form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = this.getAttribute('action');
                let method = this.querySelector('input[name="_method"]') ? 
                            this.querySelector('input[name="_method"]').value : 'POST';
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.textContent;
                submitBtn.textContent = 'Memproses...';
                submitBtn.disabled = true;
                
                fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Close the form
                        const formContainer = this.closest('.review-form');
                        formContainer.style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                        
                        // Show success message
                        alert(data.message);
                        
                        // Reload the page to reflect changes
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.error || 'Terjadi kesalahan saat menyimpan data');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.textContent = originalBtnText;
                    submitBtn.disabled = false;
                });
            });
        });
    </script>
</body>
</html>