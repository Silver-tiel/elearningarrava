<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PusatInformasiNiereTest extends TestCase
{
    use RefreshDatabase;
    public function test_standalone_informasi_page_is_removed(): void
    {
        $response = $this->get('/informasi');
        $response->assertStatus(404);

        $redirectRes = $this->get('/pusat-informasi');
        $redirectRes->assertStatus(404);
    }

    public function test_niere_widget_is_present_on_login_and_pendaftaran(): void
    {
        $loginRes = $this->get(route('login'));
        $loginRes->assertStatus(200);
        $loginRes->assertSee('niere-widget-container');
        $loginRes->assertSee('pos-bottom');
        $loginRes->assertSee('niere-sprite');

        $regRes = $this->get(route('pendaftaran'));
        $regRes->assertStatus(200);
        $regRes->assertSee('niere-widget-container');
        $regRes->assertSee('pos-top');
        $regRes->assertSee('niere-sprite');
    }

    public function test_niere_widget_is_hidden_when_mengerjakan_quiz_or_viewing_quiz_detail(): void
    {
        $quiz = new \App\Models\Quiz([
            'id_quiz' => 1,
            'judul' => 'Kuis Matematika',
            'mode_pengerjaan' => 'wayground'
        ]);
        $quiz->setRelation('soal', collect());
        $quiz->setRelation('hasil', collect());

        $renderedMengerjakan = view('siswa.mengerjakan-quiz', [
            'quiz' => $quiz,
            'isPreview' => true,
        ])->render();

        $this->assertStringNotContainsString('niere-widget-container', $renderedMengerjakan);

        $renderedDetail = view('siswa.quiz-detail', [
            'quiz' => $quiz,
            'totalPoin' => 100,
            'totalSoal' => 10,
            'hasilSiswa' => null,
        ])->render();

        $this->assertStringNotContainsString('niere-widget-container', $renderedDetail);
    }
}

