<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'birth_date'];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function addPhone(string $number)
    {
        $this->phones()->create(['number' => $number]);
    }

    public function addPhones(array $numbers)
    {
        foreach ($numbers as $number) {
            $this->addPhone($number);
        }
    }
}
