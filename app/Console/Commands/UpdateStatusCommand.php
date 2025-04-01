<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Intervention;
use Carbon\Carbon;

class UpdateStatusCommand extends Command
{
    protected $signature = 'update:status';
    protected $description = 'Update emetteur status to active when t2 is reached';

    public function handle()
    {
        $now = Carbon::now();

        $interventions = Intervention::whereNotNull('date_reparation_fait')
            ->where('date_reparation_fait', '<=', $now)
            ->get();

        $updatedCount = 0;

        foreach ($interventions as $intervention) {
            $emetteur = $intervention->emetteur;  // Using the defined relationship

            if ($emetteur && $emetteur->status === 'En cours de réparation') {
                $emetteur->status = 'active';
                $emetteur->save();
                $updatedCount++;
            }
        }

        $this->info("Updated {$updatedCount} emetteur statuses to 'active'.");
    }
}
