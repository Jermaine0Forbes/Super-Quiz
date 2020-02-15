<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subsection;
use App\SubsectForQuest;

class QuestCorrect extends Model
{

    const CREATED_AT = null;

    protected $table = "quest_correct";

    public function subsections(){
      return $this->belongsToMany("App\Subsection", "subsect_for_quests", "quest_id", "subsect_id");
      // return $this->belongsToMany("App\Subsection", "subsect_for_quests", "quest_id", "subsect_id")->using("App\SubsectForQuest");
    }
}
