<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KinerjaController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();
        $users = User::where('id', '!=', Auth::id())
             ->where('role', 'karyawan')
             ->get();
        return view('dashboard', compact('users', 'currentUser'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|in:baik,sedang,buruk',
            'review' => 'required|string|max:500',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'rating' => $request->input('rating'),
            'review' => $request->input('review')
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'rating' => $user->rating,
                'review' => $user->review
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Kinerja berhasil diperbarui.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
}