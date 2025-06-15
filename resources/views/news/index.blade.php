@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Berita</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Berita</h6>
            @if(auth()->user()->role == 'editor')
                <div>
                    <a href="{{ route('news.index') }}" class="btn btn-secondary btn-sm {{ !request()->has('filter') ? 'active' : '' }}">Semua</a>
                    <a href="{{ route('news.index', ['filter' => 'draft']) }}" class="btn btn-primary btn-sm {{ request()->has('filter') && request()->filter == 'draft' ? 'active' : '' }}">Draft</a>
                </div>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if(auth()->user()->role == 'wartawan')
                    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Buat Berita Baru</a>
                @endif
                @if($news->isEmpty())
                    <p class="text-center">Tidak ada berita.</p>
                @else
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Pengirim</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news as $item)
                                <tr>
                                    <td>
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ route('news.show', $item) }}" class="text-primary">{{ $item->title }}</a></td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        @if($item->status == 'draft')
                                            <span class="btn btn-warning btn-sm">{{ ucfirst($item->status) }}</span>
                                        @elseif($item->status == 'approved')
                                            <span class="btn btn-success btn-sm">{{ ucfirst($item->status) }}</span>
                                        @else
                                            <span class="btn btn-secondary btn-sm">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->role == 'editor' && $item->status == 'draft')
                                            <form action="{{ route('news.approve', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                            </form>
                                        @endif
                                        @if(auth()->user()->role == 'admin' || (auth()->user()->role == 'wartawan' && $item->user_id == auth()->user()->id))
                                            <a href="{{ route('news.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('news.destroy', $item) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</button>
                                            </form>
                                            <a href="{{ route('news.show', $item) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if(session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
@endsection