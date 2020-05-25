<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'ranking';
    protected $fillable = ['nick', 'time', 'id_escaperoom'];
}
