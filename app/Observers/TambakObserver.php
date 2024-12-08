<?php

namespace App\Observers;

use App\Models\Farm;
use App\Models\Kolam;
use App\Models\Tambak;

class TambakObserver
{
    public function created(Kolam $kolam)
    {
        $this->updateKolamCount($kolam);
    }

    public function deleted(Kolam $kolam)
    {
        $this->updateKolamCount($kolam);
    }

    private function updateKolamCount(Kolam $kolam)
    {
        $tambak = Farm::find($kolam->farm_id);
        if ($tambak) {
            $tambak->kolam = $tambak->kolams()->count();
            $tambak->save();
        }
    }
}

