@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <div>
                <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
            </div>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 mb-4">
                <!-- Welcome Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-gradient-primary text-white">
                        <h6 class="m-0 font-weight-bold">Selamat Datang, {{ $user->name }}!</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Role: <span class="font-weight-bold">{{ ucfirst($user->role) }}</span></p>
                        <p class="text-dark">
                            @if($user->role == 'admin')
                                Anda memiliki <span class="font-italic text-success">akses penuh</span> untuk mengelola semua berita.
                            @elseif($user->role == 'editor')
                                Anda dapat <span class="font-italic text-info">menyetujui berita</span> untuk dipublikasikan.
                            @elseif($user->role == 'wartawan')
                                Anda dapat <span class="font-italic text-warning">membuat, mengedit, dan menghapus</span> berita Anda sendiri.
                            @endif
                        </p>
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- News Summary -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-gradient-primary text-white">
                        <h6 class="m-0 font-weight-bold">Ringkasan Berita</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Draft News Count -->
                            @php
                                $draftNews = $user->role == 'admin' || $user->role == 'editor' ? $news->where('status', 'draft') : $news->where('user_id', $user->id)->where('status', 'draft');
                                $draftCount = $draftNews->count();
                            @endphp
                            @if($user->role == 'admin' || $user->role == 'editor' || ($user->role == 'wartawan' && $draftCount > 0))
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2" style="transition: all 0.3s ease;">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Berita Draft</div>
                                                    <div class="h3 mb-0 font-weight-bold text-gray-800" style="transition: color 0.3s ease;">{{ $draftCount }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-clipboard-list fa-3x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Uploaded News Count -->
                            @php
                                $uploadedNews = $user->role == 'admin' || $user->role == 'editor' ? $news->where('status', 'uploaded') : $news->where('user_id', $user->id)->where('status', 'uploaded');
                                $uploadedCount = $uploadedNews->count();
                            @endphp
                            <!-- @if($user->role == 'admin' || $user->role == 'editor' || ($user->role == 'wartawan' && $uploadedCount > 0))
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-info shadow h-100 py-2" style="transition: all 0.3s ease;">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Berita Diunggah</div>
                                                    <div class="h3 mb-0 font-weight-bold text-gray-800" style="transition: color 0.3s ease;">{{ $uploadedCount }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-upload fa-3x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif -->

                            <!-- Approved News Count -->
                            @php
                                $approvedNews = $user->role == 'admin' || $user->role == 'editor' ? $news->where('status', 'approved') : $news->where('user_id', $user->id)->where('status', 'approved');
                                $approvedCount = $approvedNews->count();
                            @endphp
                            @if($user->role == 'admin' || $user->role == 'editor' || ($user->role == 'wartawan' && $approvedCount > 0))
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-success shadow h-100 py-2" style="transition: all 0.3s ease;">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Berita Disetujui</div>
                                                    <div class="h3 mb-0 font-weight-bold text-gray-800" style="transition: color 0.3s ease;">{{ $approvedCount }}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-check-circle fa-3x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($user->role == 'wartawan')
                            <a href="{{ route('news.create') }}" class="btn btn-primary btn-lg mt-4">Buat Berita Baru</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection