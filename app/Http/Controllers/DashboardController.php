<?php
namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            // Admin melihat semua berita (bisa disesuaikan jika hanya dari wartawan)
            $news = News::with('category', 'user')->get();
        } elseif ($user->role == 'editor') {
            // Editor melihat semua berita
            $news = News::with('category', 'user')->get();
        } elseif ($user->role == 'wartawan') {
            // Wartawan hanya melihat berita miliknya
            $news = News::with('category', 'user')->where('user_id', $user->id)->get();
        } else {
            $news = collect(); // Jika peran tidak dikenali, kosongkan
        }

        return view('dashboard', compact('user', 'news'));
    }
}