<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'title', 'description', 'status', 'subject', 'comment', 'user_id'];

    /*
     * Ein Angebot hat mehrere Terminvorschläge
     */
    public function appointments() : HasMany {
        return $this->hasMany(Appointment::class);
    }

    /*
     * Ein Angebot wird von einer Person erstellt
     */
    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    //Übungsfunktionen
    /*public function isOpen():bool {
        return $this->status == 'offen';
    }*/
    /*public static function open(){
        return static::where('status', '==', 'offen')->get();
    }*/
}
