<?php

namespace App\Console\Commands;

use App\Models\Admin\Emetteur;
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

        $interventions = Intervention::whereNotNull('date_reparation')
            ->where('date_reparation', '<=', $now)
            ->get();

        $updatedCount = 0;

        foreach ($interventions as $intervention) {
            $emetteur = Emetteur::findOrFail($intervention->emetteur_id);

            if ($emetteur && $emetteur->status === 'En cours de réparation') {
                $emetteur->status = 'active';
                $emetteur->save();
                $updatedCount++;
            }
        }

        $this->info("Updated {$updatedCount} emetteur statuses to 'active'.");
    }
}
