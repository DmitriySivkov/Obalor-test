<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Customer extends Model
{
    use HasFactory;

    protected array $guarded = [];

    public function setAgeAttribute($value)
    {
        $age = (int)$value;

        if ($age && 18 <= $age && $age <= 99)
            $this->attributes['age'] = Carbon::now()->subYears($age);
        else
            throw new \Exception('age');
    }

    public function setEmailAttribute($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL))
            $this->attributes['email'] = $value;
        else
            throw new \Exception('email');
    }

    public function setLocationAttribute($value)
    {
        $country = Country::where('name', $value)->first();
        if (!$country)
            $this->attributes['location'] = 'Unknown';
        else {
            $this->attributes['location'] = $country->name;
            $this->attributes['country_code'] = $country->alpha3;
        }
    }
}
