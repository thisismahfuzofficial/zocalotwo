<?php

namespace App\Models\Traits;

use App\Models\Log;

trait HasLog
{
    public function logs()
    {
        return $this->morphMany(Log::class, 'logable');
    }


    public function logCreated()
    {
        $this->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'created',
            'meta' => json_encode($this->getLoggableAttributes('created')),
        ]);
    }

    public function logUpdated()
    {
        $this->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'updated',
            'meta' => json_encode($this->getLoggableAttributes('updated')),
        ]);
    }

    public function logDeleted()
    {
        $this->logs()->create([
            'user_id' => auth()->id(),
            'action' => 'deleted',
            'meta' => json_encode($this->getLoggableAttributes('deleted')),
        ]);
    }

    /**
     *
     * @param string $action
     * @return array
     */
    protected function getLoggableAttributes(string $action = 'all')
    {
        $attributes = $this->getAttributes(); 
        return [
            'restaurant_id' => $attributes['restaurant_id'] ?? null,
        ];
    }
}
