<?php

namespace App\Observers;

use App\Models\Part;

class PartObsever
{
    /**
     * Handle the Part "created" event.
     */
    public function created(Part $part): void
    {
        // run on add for new
        $className= ucfirst($part->part);
        $handle = "\\Resources\\Views\\Segments\\$className";
        $handle::onAdd($part);
    }

    /**
     * Handle the Part "updated" event.
     */
    public function updated(Part $part): void
    {
        // remove old part  add new part

        if ($part->isDirty('part')){
            $className = ucfirst($part->getOriginal('part'));
            $handle = "\\Resources\\Views\\Segments\\$className";
            $handle::onRemove($part);

            $className = $part->part;
            $className= ucfirst($part->part);
            $handle = "\\Resources\\Views\\Segments\\$className";
            $handle::onAdd($part);
        }

    }

    /**
     * Handle the Part "deleted" event.
     */
    public function deleted(Part $part): void
    {
        // remove part
        $className= ucfirst($part->part);
        $handle = "\\Resources\\Views\\Segments\\$className";
        $handle::onRemove($part);
    }

    /**
     * Handle the Part "restored" event.
     */
    public function restored(Part $part): void
    {
        //
    }

    /**
     * Handle the Part "force deleted" event.
     */
    public function forceDeleted(Part $part): void
    {
        //
    }
}
