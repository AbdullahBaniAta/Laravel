<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelTarget extends Model
{
    protected $table = 'channel_target';
    protected $guarded = ['id'];
    public $timestamps = false;
}
