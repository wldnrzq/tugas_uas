@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Berita</h1>
    </div>

    <!-- Detail News -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary">{{ $news->title }}</h4>
        </div>
        <div class="card-body">
            @if($news->image)
                <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="img-fluid mb-4" style="max-height: 300px; object-fit: cover; border-radius: 5px;">
            @endif
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><strong>Kategori:</strong> <span class="text-muted">{{ $news->category->name }}</span></p>
                    <p class="mb-1"><strong>Pengirim:</strong> <span class="text-muted">{{ $news->user->name }}</span></p>
                    <p class="mb-1"><strong>Status:</strong>
                        @if($news->status == 'draft')
                            <span class="btn btn-warning btn-sm">{{ ucfirst($news->status) }}</span>
                        @elseif($news->status == 'approved')
                            <span class="btn btn-success btn-sm">{{ ucfirst($news->status) }}</span>
                        @else
                            <span class="btn btn-secondary btn-sm">Unknown</span>
                        @endif
                    </p>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-body bg-light p-3">
                    <p class="text-dark">{{ $news->content }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-secondary">Kembali</a>
                @if(auth()->user()->role == 'admin' || (auth()->user()->role == 'wartawan' && $news->user_id == auth()->user()->id))
                    <a href="{{ route('news.edit', $news) }}" class="btn btn-warning ml-2">Edit</a>
                    <form action="{{ route('news.destroy', $news) }}" method="POST" style="display:inline; margin-left: 10px;" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection