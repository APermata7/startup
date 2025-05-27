<?php

namespace App\Http\Controllers;

use App\Models\Kinerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KinerjaController extends Controller
{
    /**
     * Menampilkan dashboard dengan daftar karyawan yang bisa direview
     * (Menggantikan fungsi index sebelumnya)
     */
    public function listKaryawan()
    {
        // Ambil semua karyawan kecuali diri sendiri
        $karyawanList = User::where('id', '!=', Auth::id())
                          ->where('role', 'karyawan')
                          ->with(['reviewsReceived' => function($query) {
                              $query->with('penilai');
                          }])
                          ->get();

        return view('dashboard', [
            'karyawanList' => $karyawanList,
            'currentUser' => Auth::user()
        ]);
    }

    /**
     * Menampilkan form untuk membuat review baru
     */
    public function create($karyawanId)
    {
        // Pastikan user tidak bisa mereview dirinya sendiri
        if (Auth::id() == $karyawanId) {
            return redirect()->back()->with('error', 'Anda tidak bisa mereview diri sendiri.');
        }

        $karyawan = User::findOrFail($karyawanId);
        
        // Cek apakah sudah pernah memberikan review
        $existingReview = Kinerja::where('penilai_id', Auth::id())
                                ->where('dinilai_id', $karyawanId)
                                ->first();

        return view('kinerja.create', [
            'karyawan' => $karyawan,
            'existingReview' => $existingReview
        ]);
    }

    /**
     * Menyimpan review baru
     */
    public function store(Request $request, $karyawanId)
{
    $request->validate([
        'rating' => 'required|in:baik,sedang,buruk',
        'review' => 'nullable|string|max:1000'
    ]);

    if (Auth::id() == $karyawanId) {
        return response()->json([
            'success' => false,
            'error' => 'Anda tidak bisa mereview diri sendiri.'
        ], 422);
    }

    $existingReview = Kinerja::where('penilai_id', Auth::id())
                            ->where('dinilai_id', $karyawanId)
                            ->first();

    if ($existingReview) {
        return response()->json([
            'success' => false,
            'error' => 'Anda sudah memberikan review untuk karyawan ini.'
        ], 422);
    }

    $review = Kinerja::create([
        'penilai_id' => Auth::id(),
        'dinilai_id' => $karyawanId,
        'rating' => $request->rating,
        'review' => $request->review
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Review berhasil disimpan.',
        'review' => $review
    ]);
}

public function update(Request $request, $reviewId)
{
    $request->validate([
        'rating' => 'required|in:baik,sedang,buruk', // Ubah dari nullable ke required
        'review' => 'nullable|string|max:1000'
    ]);

    $review = Kinerja::where('id', $reviewId)
                    ->where('penilai_id', Auth::id())
                    ->firstOrFail();

    $review->update([
        'rating' => $request->input('rating'), // Gunakan input() untuk memastikan
        'review' => $request->input('review')
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Review berhasil diperbarui.',
        'review' => $review
    ]);
}

    /**
     * Menampilkan daftar review yang diterima seorang karyawan
     */
    public function showReviews($karyawanId)
    {
        $karyawan = User::findOrFail($karyawanId);
        $reviews = $karyawan->reviewsReceived()->with('penilai')->get();

        return view('kinerja.show', [
            'karyawan' => $karyawan,
            'reviews' => $reviews
        ]);
    }

    /**
     * Menampilkan profil pengguna
     */
    public function profile()
    {
        $user = Auth::user();
        $reviewsReceived = $user->reviewsReceived()->with('penilai')->get();
        $reviewsGiven = $user->reviewsGiven()->with('dinilai')->get();

        return view('profile', [
            'user' => $user,
            'reviewsReceived' => $reviewsReceived,
            'reviewsGiven' => $reviewsGiven
        ]);
    }

    
}