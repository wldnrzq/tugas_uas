@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Edit Berita</h1>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('news.update', $news) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Judul</label>
                        <input type="text" name="title" class="form-control" value="{{ $news->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Konten</label>
                        <textarea name="content" class="form-control" rows="5" required>{{ $news->content }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">Pilih</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $news->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar</label>
                        @if($news->image)
                            <img src="{{ asset('storage/' . $news->image) }}" alt="Current Image" style="max-width: 200px; margin-bottom: 10px;">
                        @endif
                        <input type="file" name="image" class="form-control-file" accept="image/jpg,image/jpeg,image/png">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection