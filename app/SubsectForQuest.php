<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SubsectForQuest extends Model
{
    protected $fillable = ["quest_id","subsect_id"];
}
