<?php

namespace App\Console\Commands;

use App\Services\DungeonService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class CloseStaleDungeonSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dungeon:close-stale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menutup sesi Dungeon yang sudah basi atau melewati batas waktu pengerjaan secara otomatis.';

    /**
     * Execute the console command.
     */
    public function handle(DungeonService $dungeonService): int
    {
        $this->info('Memeriksa sesi Dungeon yang basi...');

        $closedCount = $dungeonService->autoCloseAllStaleSessions();

        $this->info("Berhasil menutup {$closedCount} sesi Dungeon basi.");

        return SymfonyCommand::SUCCESS;
    }
}
