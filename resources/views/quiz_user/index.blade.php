@extends('header_user.header')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Quiz</h4>
    </div>

    <!-- Filter Category Tabs -->
    <ul class="nav nav-pills mb-4 gap-2" id="quizTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active rounded-pill px-3" data-bs-toggle="tab">Semua</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-3" data-bs-toggle="tab">Matematika</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-3" data-bs-toggle="tab">Bahasa Inggris</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-3" data-bs-toggle="tab">IPA</button>
        </li>
        <li class="nav-item">
            <button class="nav-link rounded-pill px-3" data-bs-toggle="tab">IPS</button>
        </li>
    </ul>

    <!-- Grid Quiz Cards -->
    <div class="row g-4">
        @forelse($quizzes as $quiz)
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-3">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-primary-subtle text-primary fw-medium px-2 py-1 rounded-3">
                                {{ $quiz->tag ?? 'Umum' }}
                            </span>
                            <small class="text-muted fs-7">{{ $quiz->questions_count }} Soal</small>
                        </div>
                        <span class="text-warning fw-bold small d-block mb-1">{{ strtoupper($quiz->category ?? 'QUIZ') }}</span>
                        <h6 class="fw-bold text-dark mb-3">{{ $quiz->title }}</h6>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <small class="text-muted"><i class="bi bi-people me-1"></i>{{ $quiz->attempts_count ?? 0 }} Siswa Ikut</small>
                        
                        <!-- Form Mulai Quiz -->
                        <form action="{{ route('quiz.start', $quiz->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-3 px-4 btn-sm fw-semibold">Mulai</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Belum ada quiz yang tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection