<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\SpotGood\SpotGood
*/


namespace Drupal\cvprocessing\CVProcesses\SpotGood;
use Drupal\cvprocessing\CVProcesses\DotsToDotWithSpaces\DotProcess;
use Drupal\get_streams\GetStreamsService\GetStreams;

/**
 * Spots good words in the cv and surrounds them with marker characters ???? and css
 */
class SpotGoodWords {

  private $dotprocess;
  private $streams;

  /**
  * Constructs a SpotGoodWords object.
  *
  * @param Drupal\cvprocessing\CVProcesses\DotsToDotWithSpaces\DotProcess $dotprocess
  *   The service which prosses fullstops, commas etc
  * @param Drupal\get_streams\GetStreamsService\GetStreams $streams
  *   The service which gets streams of words to find
  */
  public function __construct(DotProcess $dotprocess, GetStreams $streams) {
    $this->dotprocess = $dotprocess;
    $this->streams = $streams;
  }


  /**
  * Returns the cv with the good words turned green and fullstops, commas etc are left intact.
  *
  * @param String $data
  *
  *  The actual submitted cv
  * @return String
  *
  */
  public function goodprocess($data) {

    $collectedgoodwords ="????";

    /* Fullstops etc are surrounded by spaces so then do not interfere with word detection */
    $data =  $this->dotprocess->processthedots($data);

    // Gets all the good words
    $goodwordstofind= trim($this->streams->generateStream("good word") );

    // Turns stream into an array
    $goodwordstofind = explode("*", $goodwordstofind);

    for ($x = 0; $x < count($goodwordstofind); $x++) {

      // Hunts for each word in array of good words and replaces it when found

      if( !empty($goodwordstofind[$x])) {
       $data = str_replace( " " . $goodwordstofind[$x] . " "," " ."<span class = goodword >" . $collectedgoodwords  . $goodwordstofind[$x] . $collectedgoodwords . "</span>",$data);
      }

    }

    for ($x = 0; $x < count($goodwordstofind); $x++) {

      /* Hunts for each word in array of good words if first letter is capital and replaces it when found */

      if(!empty($goodwordstofind[$x])) {
      $data = str_replace( ucwords($goodwordstofind[$x]),"<span class = goodword >" . $collectedgoodwords .  ucwords($goodwordstofind[$x]) . $collectedgoodwords  . "</span>",$data);

      }

    }

    // Detects line breaks and preserves them
    $data = preg_replace('/[\r\n]+/i', "<br>", $data);


    return $data .  $collectedgoodwords ;
  }
}

