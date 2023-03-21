<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    public function __construct(){
        $this->middleware('auth');
    }

    public function path(){
        return "/books".$this->id;
    }
    public function checkout(User $user){

        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
    }
    public function checkin(User $user){

        $reservation = $this->reservations()->where('user_id',$user->id)
        ->whereNotNull('checked_out_at')
        ->whereNull('checked_in_at')
        ->first();

        if(is_null($reservation)){
            throw new \Exception();
        }

        $reservation->update([
            'checked_out_at'=>null
        ]);
    }

    public function setAuthorIdAttributes($author){

        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name'=>$author,
        ]))->id;
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
