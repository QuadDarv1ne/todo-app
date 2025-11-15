<?php

namespace App\Console\Commands;

use App\Services\AchievementService;
use Illuminate\Console\Command;

class SeedAchievements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'achievements:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed initial achievements into the database';

    /**
     * Execute the console command.
     */
    public function handle(AchievementService $achievementService): int
    {
        $this->info('Seeding achievements...');
        
        $achievementService->seedAchievements();
        
        $this->info('Achievements seeded successfully!');
        
        return self::SUCCESS;
    }
}
