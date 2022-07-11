<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    use HasFactory;

     protected $fillable = [
        'message_id',
        'sender_id',
        'receiver_id',
        'text',
       
    ];
   
      public function user(){
        return $this->belongsTo(User::class);
        //Un message ne peut etre valider que par in seul user
    }


}
