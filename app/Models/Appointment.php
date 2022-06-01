<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'status', 'label', 'starttime', 'endtime', 'user_id', 'offer_id'];
    /*
     * Terminvorschläge haben jeweils ein Angebot zu dem sie gehören
     */
    public function offer() : BelongsTo{
        return $this->belongsTo(Offer::class);
    }

    /*
     * Terminvorschläge werden von Nachhilfesuchenden
     * als passend markiert
     */
    public function user() : BelongsTo{
        return $this->belongsTo(User::class);
    }
}
