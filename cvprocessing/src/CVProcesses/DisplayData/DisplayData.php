<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\AllCVProcessing\DisplayData\DisplayData
*/

namespace Drupal\cvprocessing\CVProcesses\DisplayData;

class DisplayData {


  /**
  *
  * Builds statistical display data.
  *
  *
  */


  /**
  * Returns the statistical data for a cv.
  *
  * @param String $processeddata
  *
  * The actual submitted cv with all its words processed
  *
  * @return String
  *
  * Statistical data of each type of word
  *
  */
  public function makedisplays($data) {

  //////////////////////////////////////////////////////////
  preg_match_all('/([?]{4}[\w]+[?]{4})/', $data , $matches);


  // makes each array content lower case
  $matches[0] = array_map('strtolower', $matches[0]);

  $arrayofgoodwords = array_unique ($matches[0]);

  sort($arrayofgoodwords);

  $goodwordstodisplay = "";

  foreach ($arrayofgoodwords as $good) {

    $goodwordstodisplay.= "<li>" . $good . "</li>" ;

  }

  $goodwordstodisplay = "<div><ul>" . $goodwordstodisplay . "</ul></div>";

  $goodwordstats =  "<div class = goodwordstodisplay>" . "The number of good words is : " . count( $arrayofgoodwords) . "<br>" . $goodwordstodisplay . "</div>" ;

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  preg_match_all('/([£]{4}[\w]+[£]{4})/', $data , $matches);


  // makes each array content lower case
  $matches[0] = array_map('strtolower', $matches[0]);

  $arrayofbadwords = array_unique ($matches[0]);

  sort($arrayofbadwords);

  $badwordstodisplay = "";

  foreach ($arrayofbadwords as $bad) {

    $badwordstodisplay.= "<li>" . $bad . "</li>" ;

  }

  $badwordstodisplay = "<div><ul>" . $badwordstodisplay . "</ul></div>";

  $badwordstats =  "<div class = badwordstodisplay>" . "The number of bad words is : " . count( $arrayofbadwords) . "<br>" . $badwordstodisplay . "</div>" ;


  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  preg_match_all('/([B]{4}[\w\s]+[B]{4})/', $data , $matches);


  // makes each array content lower case
  $matches[0] = array_map('strtolower', $matches[0]);

  $arrayofbadphrasewords = array_unique ($matches[0]);

  sort($arrayofbadphrasewords);

  $badphrasewordstodisplay = "";

  foreach ($arrayofbadphrasewords as $badphrase) {

    $badphrasewordstodisplay.=  "<div><li>" . $badphrase . "</li></div>";

  }

  $badphrasewordstodisplay =  "<div><ul>" . $badphrasewordstodisplay . "</ul></div>";

  $badphrasewordstats = "<div class = badwordstodisplay>" . "The number of bad phrases is : " . count( $arrayofbadphrasewords) . "<br>" .  $badphrasewordstodisplay . "</div>" ;

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  preg_match_all('/([#]{4}[\w\s]+[#]{4})/', $data , $matches);


  // makes each array content lower case
  $matches[0] = array_map('strtolower', $matches[0]);

  $arrayofpassivewords = array_unique ($matches[0]);

  sort($arrayofpassivewords);

  // ensures single string values are not displayed
  foreach ($arrayofpassivewords as $key => $value) {

    $strlen = str_word_count( $value );

    if (  $strlen == 1 ) {
      unset($arrayofpassivewords[$key]);
    }

  }


  $passivewordstodisplay = "";

  foreach ($arrayofpassivewords as $passive) {

    $passivewordstodisplay.=   "<div><li>" . $passive . "</li></div>";

  }

  $passivewordstodisplay =  "<ul>" . $passivewordstodisplay . "</ul>";

  $passivewordstats =  "<div class = badwordstodisplay>" . "The number of passive phrases is : " . count( $arrayofpassivewords) . "<br>" . $passivewordstodisplay . "</div>" ;

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


  preg_match_all('/([PPPP]{4}[\w]+[PPPP]{4})/', $data , $matches);


  // makes each array content lower case
  $matches[0] = array_map('strtolower', $matches[0]);

  $arrayofpronounwords = $matches[0] ;

  sort($arrayofpronounwords);

  $pronounwordstodisplay = "";

  foreach ($arrayofpronounwords as $pronoun) {


    $pronounwordstodisplay.=  "<div><li>" . $pronoun . "</li></div>";

  }

  $pronounwordstodisplay = "<ul>" . $pronounwordstodisplay . "</ul>";
  $pronounwordstodisplay = preg_replace('/( [i][\s])/', " I ",  $pronounwordstodisplay);

  $pronounwordstats =  "<div class = badwordstodisplay>" . "The number of pronouns  used is  : " . count( $arrayofpronounwords) . "<br>" . $pronounwordstodisplay . "</div>" ;

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  $goodwordstats = "<span class = goodwordstats>" . $goodwordstats . "</span>" ;


  return   $goodwordstats .  $badwordstats .  $badphrasewordstats . $passivewordstats . $pronounwordstats;
  }
}

