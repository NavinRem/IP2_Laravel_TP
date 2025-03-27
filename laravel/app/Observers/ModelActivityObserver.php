<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ModelActivityObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        ActivityLog::create([
            'model'    => get_class($order),
            'model_id' => $order->id,
            'action'   => 'created',
            'changes'  => json_encode($order->toArray()),
        ]);
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        ActivityLog::create([
            'model'    => get_class($order),
            'model_id' => $order->id,
            'action'   => 'updated',
            'changes'  => json_encode([
                'old' => $order->getOriginal(),
                'new' => $order->getChanges(),
            ]),
        ]);
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        ActivityLog::create([
            'model'    => get_class($order),
            'model_id' => $order->id,
            'action'   => 'deleted',
            'changes'  => json_encode($order->toArray()),
        ]);
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
