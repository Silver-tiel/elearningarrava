@extends('header_user.header')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Ruang Quiz -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold mb-0">Ruang Quiz Interaktif</h5>
    </div>

    <!-- Form Submit Jawaban -->
    <form action="{{ route('quiz.submit', ['quiz' => $quiz->id, 'attempt' => $attempt->id]) }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Area Soal & Pilihan -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $quiz->title }}</h6>
                            <small class="text-muted">{{ $quiz->description ?? 'Jawablah pertanyaan berikut dengan benar.' }}</small>
                        </div>
                        <div class="badge bg-danger-subtle text-danger px-3 py-2 rounded-3 fs-6">
                            <i class="bi bi-clock me-1"></i> 14 : 22
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>Total Soal: {{ $quiz->questions->count() }} Soal</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>

                    <!-- Loop Pertanyaan dari Database -->
                    @foreach($quiz->questions as $index => $question)
                    <div class="my-4 pb-4 border-bottom">
                        <p class="fw-medium text-dark fs-6">{{ $index + 1 }}. {{ $question->question_text }}</p>

                        <!-- Loop Opsi Jawaban -->
                        <div class="d-flex flex-column gap-3 mt-3">
                            @foreach($question->options as $option)
                            <label class="border rounded-3 p-3 d-flex align-items-center cursor-pointer">
                                <input type="radio" 
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $option->id }}" 
                                       class="form-check-input me-3" 
                                       required>
                                <span class="fw-medium">{{ $option->option_text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach

                    <!-- Navigasi & Submit -->
                    <div class="d-flex justify-content-end pt-3">
                        <button type="submit" class="btn btn-primary px-4 rounded-3">Selesai & Submit</button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Informasi Quiz -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
                    <h6 class="fw-bold mb-3">Informasi Quiz</h6>
                    <table class="table table-borderless table-sm mb-0 text-muted fs-7">
                        <tr>
                            <td>Mata Pelajaran</td>
                            <td class="fw-semibold text-end text-dark">{{ $quiz->category ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Soal</td>
                            <td class="fw-semibold text-end text-dark">{{ $quiz->questions->count() }} Butir</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection