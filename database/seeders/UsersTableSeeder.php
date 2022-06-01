<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // test user
        $user=new User();
        $user->name='Max Mustermann';
        $user->email='max@gmail.com';
        $user->password= bcrypt('passwort');
        $user->role='tutor';
        $user->education='Matura, Bachelor in Angewandte Mathematik';
        $user->save();

        $user2=new User();
        $user2->name='Andrea Muster';
        $user2->email='andrea@gmail.com';
        $user2->password= bcrypt('passwort');
        $user2->role='tutor';
        $user2->education='Matura, Bachelor in KWM';
        $user2->save();

        $user3=new User();
        $user3->name='Finn Franke';
        $user3->email='finn@gmail.com';
        $user3->password= bcrypt('passwort');
        $user3->role='student';
        $user3->education='Matura, studiere gerade im 2. Semester KWM';
        $user3->save();

        $user4=new User();
        $user4->name='Sophie Müller';
        $user4->email='sophie@gmail.com';
        $user4->password= bcrypt('passwort');
        $user4->role='student';
        $user4->education='Matura, studiere jetzt Kommunikation';
        $user4->save();
    }
}
