<?php

namespace App\Actions\WhatsApp;

use Illuminate\Support\Fluent;

class LocationMessage
{
    public function handle($latitude, $longitude, $locationName, $address)
    {
        $fluent = new Fluent();

        return $fluent
            ->set('type', 'location')
            ->set('payload.latitude', $latitude)
            ->set('payload.longitude', $longitude)
            ->set('payload.locationName', $locationName)
            ->set('payload.address', $address);
    }
}