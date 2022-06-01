<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Offer 1
        $offer = new Offer();
        $offer->title = "Angewandte Mathematik, Nachhilfe von Ex UniXY Student";
        $offer->description = "Nachhilfe für das 1. Semester AM. Professoren X und Professoren Y kenne ich gut.";
        $offer->subject = "Mathematik";
        //Nutzer zuordnen
        $user = User::all()->first();
        $user2 = User::where('id', 2);
        $offer->user()->associate($user);
        //in die DB speichern
        $offer->save();

        //Termine anlegen
        $appointment1 = new Appointment();
        $appointment1->label = "Prio1";
        $appointment1->starttime = "2022-07-05T12:00";
        $appointment1->endtime = "2022-07-05T13:00";
        $appointment1->user()->associate($user);

        $appointment2 = new Appointment();
        $appointment2->label = "Prio2";
        $appointment2->starttime = "2022-07-06T12:00";
        $appointment2->endtime = "2022-07-06T13:00";
        $appointment2->user()->associate($user);

        $offer->appointments()->saveMany([$appointment1, $appointment2]);
        $offer->save();



        //Offer 2
        $offer2 = new Offer();
        $offer2->title = "Entspannte Sprachnachhilfe";
        $offer2->description = "Nachhilfe für das Englisch Level B";
        $offer2->subject = "Englisch";
        //Nutzer zuordnen
        $offer2->user()->associate($user);
        //in die DB speichern
        $offer2->save();

        //Termine anlegen
        $appointment4 = new Appointment();
        $appointment4->label = "Wäre am besten";
        $appointment4->starttime = "2022-06-05T12:00";
        $appointment4->endtime = "2022-06-05T14:00";
        $appointment4->user()->associate($user);

        $appointment5 = new Appointment();
        $appointment5->label = "Alternativ";
        $appointment5->starttime = "2022-06-05T16:00";
        $appointment5->endtime = "2022-06-05T17:00";
        $appointment5->user()->associate($user);

        $offer2->appointments()->saveMany([$appointment4, $appointment5]);
        $offer2->save();


        //Offer 3
        $offer3 = new Offer();
        $offer3->status = "Antwort";
        $offer3->title = "Unternehmenskommunikation Klausurvorbereitung";
        $offer3->description = "Nachhilfe für Unternehmenskommunikation. Eigene Erfahrung mit der LVA und Zusammenfassungen mit Insider-Wissen";
        $offer3->subject = "Unternehmenskommunikation";
        //Nutzer zuordnen
        $offer3->user()->associate($user);
        //in die DB speichern
        $offer3->save();

        //Termine anlegen
        $appointment6 = new Appointment();
        $appointment6->label = "Wäre mir am liebsten";
        $appointment6->starttime = "2022-06-11T12:00";
        $appointment6->endtime = "2022-06-11T14:00";
        $appointment6->user()->associate($user);

        $appointment7 = new Appointment();
        $appointment7->status = "Angefragt";
        $appointment7->label = "Alternativ auch 2 Stunden";
        $appointment7->starttime = "2022-06-12T16:00";
        $appointment7->endtime = "2022-06-12T17:00";
        $appointment7->user()->associate($user);

        $offer3->appointments()->saveMany([$appointment6, $appointment7]);
        $offer3->save();

    }
}
