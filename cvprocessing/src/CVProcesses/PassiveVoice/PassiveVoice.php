<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\PassiveVoice\PassiveVoice
*/

namespace Drupal\cvprocessing\CVProcesses\PassiveVoice;

use Drupal\get_streams\GetStreamsService\GetStreams;

class PassiveVoice {

  private $streams;


  /**
  * Constructs a PassiveVoice object.
  *
  * @param Drupal\get_streams\GetStreamsService\GetStreams $streams
  *   The service which gets streams of words
  *
  */
  public function __construct(GetStreams $streams) {
    $this->streams = $streams;
  }

  /**
  *
  * @return String Returns string of all passive words( good words, bad words ) separated by a *
  *
  */
  public function makeallstreams() {

    // Gets all bad words.
    $badwords = trim($this->streams->generateStream("bad word") );
    // Gets all bad words.
    $goodwords = trim($this->streams->generateStream("good word") );

    $wordsarray = $badwords . $goodwords;

    // makes for identical arrays of good and bad words.
    $words = explode("*", $wordsarray);

    $words2 = explode("*", $wordsarray);

    $words3 = explode("*", $wordsarray);

    $words4 = explode("*", $wordsarray);



    // Makes string containing passive voice words separated by a *.
    $words =  $this->cvprocessing_process_passive ($words, "was");
    $words2 =  $this->cvprocessing_process_passive ($words2, "is");
    $words3 =  $this->cvprocessing_process_passive ($words3, "were");
    $words4 =  $this->cvprocessing_process_passive ($words4, "are");

    // returns the combined string.
    return $words . $words2 . $words3 . $words4;
  }


  /**
  * Puts spaces either side of .,:: so that adjacent words can be processed
  *
  * @param array $arry
  *   The word array to be processed.
  *
  *@param String  $pass
  *    The particle used to make a passive word voice
  *
  * @return String
  *   The processed data contains words separated by a *
  *
  */
  function cvprocessing_process_passive ($arry, $pass) {

    foreach ($arry as  &$value) {

      $value =  $pass . " " . $value;

    }

    return implode("*",$arry);

  }


}

