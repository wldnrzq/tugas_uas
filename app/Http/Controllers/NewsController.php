<?php
namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        \Log::info('Categories: ' . $categories->toJson());
        return view('news.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Hanya JPG, JPEG, PNG, maks 2MB
        ]);

        $news = new News();
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->category_id = $validatedData['category_id'];
        $news->user_id = Auth::id();
        $news->status = 'draft';

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil disimpan sebagai draft.'); // Redirect ke news.index
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $news = [];

        if ($user->role == 'admin') {
            $news = News::with('category', 'user')
                ->whereHas('user', function ($query) {
                    $query->where('role', 'wartawan');
                })
                ->get();
        } elseif ($user->role == 'editor') {
            $news = News::with('category', 'user')->get();
        } else {
            $news = News::with('category', 'user')->where('user_id', $user->id)->get();
        }

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        if (Auth::user()->role == 'wartawan' && $news->user_id != Auth::id() && $news->status != 'approved') {
            abort(403, 'Unauthorized');
        }
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        if (Auth::user()->role == 'wartawan' && $news->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }
        $categories = Category::all();
        return view('news.edit', compact('news', 'categories'));
    }

    public function update(Request $request, News $news)
    {
        if (Auth::user()->role == 'wartawan' && $news->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->category_id = $validatedData['category_id'];

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->image = $imagePath;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if (Auth::user()->role == 'wartawan' && $news->user_id != Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();
        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
    }

    public function approve(News $news)
    {
        if (Auth::user()->role != 'editor') {
            abort(403, 'Unauthorized');
        }

        if ($news->status != 'draft') {
            return redirect()->back()->with('error', 'Hanya berita dengan status draft yang bisa disetujui.');
        }

        $news->status = 'approved';
        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil disetujui.');
    }
}