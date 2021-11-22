<?php

use Illuminate\Support\Facades\DB;

// Show Candidate Resume if it exist
  function getCandidateResume($id){

    $resume=DB::table('files')->where('model_id', $id )->first();

    return $resume;
  }

// Show Position Contract if it exist
   function getPositionContract($id){

    $resume=DB::table('files')->where('model_id', $id )->first();

     return $resume;
}


