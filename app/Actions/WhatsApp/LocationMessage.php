<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class LocationMessage implements MessageInterface
{
    public ?Fluent $fluent = null;

    public function with($latitude, $longitude, $locationName, $address)
    {
        $this->fluent = (new Fluent)
            ->set('type', 'location')
            ->set('payload.latitude', $latitude)
            ->set('payload.longitude', $longitude)
            ->set('payload.locationName', $locationName)
            ->set('payload.address', $address);

        return $this;
    }

    public function toArray(): array
    {
        if (!$this->fluent) {
            throw new \LogicException("You must call with() before toArray()");
        }

        return $this->fluent->toArray();
    }
}
