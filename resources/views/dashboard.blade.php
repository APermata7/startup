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
            --button-hover: #333333;
            --navbar-bg: #000000;
            --navbar-text: #ffffff;
            --navbar-hover: #333333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: var(--navbar-bg);
            color: var(--navbar-text);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 20px;
            font-weight: 600;
            color: var(--navbar-text);
            text-decoration: none;
            margin-right: auto; /* Pindahkan ke kanan */
            padding-left: 20px; /* Beri jarak dari kiri */
        }

        .navbar-actions {
            display: flex;
            gap: 15px;
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
            font-size: 14px;
        }

        .nav-btn:hover {
            color: #ddd;
        }

        .logout-btn {
            background-color: transparent;
            color: var(--navbar-text);
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 600;
        }

        .logout-btn:hover {
            background-color: var(--navbar-hover);
            border-color: var(--navbar-hover);
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
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

        /* Card Styles with fixed height */
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

        .review-display {
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
            color: var(--secondary-color);
            flex-grow: 1;
            overflow: hidden;
        }

        /* Review Form - Absolute Positioning */
        .review-form-container {
            position: relative;
        }

        .review-form {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            padding: 20px;
            z-index: 10;
            display: none;
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
            box-sizing: border-box; /* Ensure padding doesn't affect width */
        }

        /* Perbaikan margin untuk textarea */
        textarea {
            min-height: 80px;
            resize: vertical;
            margin-right: 5px; /* Tambahkan margin kanan */
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

        /* Overlay for when form is open */
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

        /* Button container for better alignment */
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <span class="navbar-brand">Dashboard</span>
        <div class="navbar-actions">
            <a href="{{ route('profile') }}" class="nav-btn">Profil Saya</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-btn">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container">
        <h2 class="page-title">Kelola Kinerja Karyawan</h2>

        <div class="users-grid">
            @foreach ($users as $user)
                <div class="review-form-container">
                    <div class="user-card" id="user-card-{{ $user->id }}">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                        <div class="user-role">{{ $user->role }}</div>
                        
                        <div class="rating-display">
                            Rating: <span id="rating-value-{{ $user->id }}">{{ $user->rating ?? 'Belum ada rating' }}</span>
                        </div>
                        
                        <div class="review-display">
                            @if($user->review)
                                "{{ $user->review }}"
                            @else
                                <span class="no-review">Belum ada review</span>
                            @endif
                        </div>
                        
                        <button class="edit-btn" onclick="toggleReviewForm({{ $user->id }})">
                            {{ $user->rating ? 'Edit Review' : 'Beri Review' }}
                        </button>
                    </div>

                    <div class="review-form" id="review-form-{{ $user->id }}">
                        <form method="POST" action="{{ route('kinerja.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="rating-{{ $user->id }}">Rating</label>
                                <select name="rating" id="rating-{{ $user->id }}" required>
                                    <option value="">Pilih Rating</option>
                                    <option value="baik" {{ $user->rating == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="sedang" {{ $user->rating == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="buruk" {{ $user->rating == 'buruk' ? 'selected' : '' }}>Buruk</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review-{{ $user->id }}">Review</label>
                                <textarea name="review" id="review-{{ $user->id }}" required>{{ $user->review ?? '' }}</textarea>
                            </div>
                            <div class="button-group">
                                <button type="submit" class="submit-btn">Kirim Kinerja</button>
                                <button type="button" class="edit-btn" onclick="toggleReviewForm({{ $user->id }})">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="overlay" id="overlay"></div>

    <script>
        function toggleReviewForm(userId) {
            const form = document.getElementById(`review-form-${userId}`);
            const overlay = document.getElementById('overlay');
            
            if (form.style.display === 'block') {
                form.style.display = 'none';
                overlay.style.display = 'none';
            } else {
                // Hide all other forms first
                document.querySelectorAll('.review-form').forEach(f => {
                    f.style.display = 'none';
                });
                form.style.display = 'block';
                overlay.style.display = 'block';
            }
        }

        // Close form when clicking on overlay
        document.getElementById('overlay').addEventListener('click', function() {
            document.querySelectorAll('.review-form').forEach(f => {
                f.style.display = 'none';
            });
            this.style.display = 'none';
        });

        // Handle form submission with fetch to stay on the same page
        document.querySelectorAll('.review-form form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const url = this.getAttribute('action');
                const userId = this.closest('.review-form-container').querySelector('.user-card').id.split('-')[2];
                
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Update the displayed rating and review
                        document.getElementById(`rating-value-${userId}`).textContent = 
                            data.rating || 'Belum ada rating';
                        
                        const reviewDisplay = document.querySelector(`#user-card-${userId} .review-display`);
                        if (data.review) {
                            reviewDisplay.innerHTML = `"${data.review}"`;
                        } else {
                            reviewDisplay.innerHTML = '<span class="no-review">Belum ada review</span>';
                        }
                        
                        // Hide the form and overlay
                        document.getElementById(`review-form-${userId}`).style.display = 'none';
                        document.getElementById('overlay').style.display = 'none';
                        
                        // Update button text
                        const button = document.querySelector(`#user-card-${userId} .edit-btn`);
                        button.textContent = data.rating ? 'Edit Review' : 'Beri Review';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
            });
        });
    </script>
</body>
</html>