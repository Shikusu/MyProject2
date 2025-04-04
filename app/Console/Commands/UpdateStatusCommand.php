<?php

namespace App\Console\Commands;

use App\Models\Admin\Emetteur;
use App\Models\Notification;
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
                $emetteur->dernier_maintenance  = $emetteur->maintenance_prevue;
                $emetteur->maintenance_prevue = null;
                $emetteur->save();
                $updatedCount++;
                $message = "La " . $emetteur->type . " localisée à " . $emetteur->localisation->nom . " est reparée";


                $notif = new Notification();
                $notif->message = $message;
                $notif->user_id = 2; //logik to be changet
                $notif->save();
            }
        }



        $this->info("Updated {$updatedCount} emetteur statuses to 'active'.");
    }
}
