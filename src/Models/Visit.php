<?php

namespace Brunocfalcao\Tracer\Models;

use Eduka\Cube\Models\Affiliate;
use Eduka\Cube\Models\User;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    // Relationship verified.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship verified.
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function updateGeoData(array $data)
    {
        $this->continent = $data['continent'];
        $this->continentCode = $data['continentCode'];
        $this->country = $data['country'];
        $this->countryCode = $data['countryCode'];
        $this->region = $data['region'];
        $this->regionName = $data['regionName'];
        $this->city = $data['city'];
        $this->district = $data['district'];
        $this->zip = $data['zip'];
        $this->latitude = $data['lat'];
        $this->longitude = $data['lon'];
        $this->timezone = $data['timezone'];
        $this->currency = $data['currency'];

        $this->update();
    }
}
