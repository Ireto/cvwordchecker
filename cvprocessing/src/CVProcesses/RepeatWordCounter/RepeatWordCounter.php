<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\RepeatWordCounter\RepeatWordCounter
*/


namespace Drupal\cvprocessing\CVProcesses\RepeatWordCounter;

/**
 * Finds repeated words, puts them in an array if they failed certain parameters
 */
class RepeatWordCounter {

  /**
  *
  * @param String $cv
  *   The cv being checked.
  *
  * @return String $overusedwordstable
  *   The list of over used words
  */
  public function cvprocessing_repeatwordcounter($cv) {
    // only checks words over this length
    define("MINIMUM_WORD_LENGTH", 3);
    // only shows words used this many times
    define("OVER_USED_COUNT", 2);

    $overusedwords = [];

    // converts cv to array
    $cv_array = explode( " ", $cv);

    // makes each word in array  unique
    $unique = array_unique($cv_array);
    // turns array values into keys
    $flipped = array_flip($unique);

    // makes each value in array zero. each value represents a word count
    foreach ($flipped as $key => $value) {
      $flipped [$key] = 0;
    }

    $length = count($cv_array);

    for ($x = 0; $x < $length; $x++) {

      if (array_key_exists($cv_array[$x],$flipped)) {

      $flipped[$cv_array[$x]] = $flipped[$cv_array[$x]] + 1 ;
      }
    }

    // sorts by number of words found for each unique word
    arsort($flipped );

    foreach($flipped as $key => $value) {

    if( (strlen($key) > MINIMUM_WORD_LENGTH)&&( $value > OVER_USED_COUNT ) ) { $overusedwords[] =  $key . " used " . $value ;} ;
    }


    foreach($overusedwords as $key => $value) {

    if ( (strpos($value,"goodword")> -1)| (strpos($value,"badword")> -1)|(strpos($value,"passive")> -1)|(strpos($value,"green")> -1)|(strpos($value,"class")> -1)|(strpos($value,"</span>") > -1 | (strpos($value,"<span")> -1)) | (empty($value)) ) {
        unset($overusedwords[$key]) ;  }

    }

    $overusedwordstable = "<div class = overusedwords>";

    foreach ($overusedwords as $key => $value) {

      $overusedwordstable.=$value . "<br>";
      # code...
    }

    $overusedwordstable.="</div>";

    return ($overusedwordstable);

    }

}

