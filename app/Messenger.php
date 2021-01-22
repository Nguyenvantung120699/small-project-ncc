<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messenger extends Model
{
    protected $table = 'messages';

    protected $fillable = ['type','from_id','to_id','body','attachment','seen'];

    public function Users (){
        return $this->belongsTo("App\User","to_id");
    }
}
