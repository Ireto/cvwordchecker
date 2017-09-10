<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\Spot\Spot
*/

namespace Drupal\cvprocessing\CVProcesses\Spot;

/**
 * Spots for bad words and surounds them in css and marker ££££
 */
class Spot {

  /**
  *
  * @param String $data
  *   The cv being checked.
  *
  *   .   *
  * @return String $badstream
  *   The string data with found words surrounded in css.
  */
  public function cvprocessing_process($data, $badstream) {

    $collectedbadword = "££££";

    $wordstoprocess = explode("*", $badstream);

    for ($x = 0; $x < count($wordstoprocess); $x++) {

      if(!empty($wordstoprocess[$x])) {
        $data = str_replace(" " .$wordstoprocess[$x] . " ","<span class = badword >" . $collectedbadword . $wordstoprocess[$x] .  $collectedbadword.  "</span>",$data);
      }

    }


    for ($x = 0; $x < count($wordstoprocess); $x++) {


      if(!empty($wordstoprocess[$x])) {
        $data = str_replace(  ucwords($wordstoprocess[$x] . " "),"<span class = badword >" .  $collectedbadword .  ucwords($wordstoprocess[$x]) .  $collectedbadword . "</span>",$data);
      }

    }

    // detects end of line in cv etc an repleces then with spaces
    $data = preg_replace('/[\r\n]+/i', "<br>", $data);


    return $data .  $collectedbadword ;
  }


  /**
  * Checks access for the users recent content tracker page.
  *
  * @param String $data
  *   The cv being checked for passive voice
  *
  *   .   *
  * @return String $badstream
  *   The string data with found passsive voice statements  surrounded in css.
  */
  public function cvprocessing_process_passive($data, $badstream) {

    $collectedpassivewords = "####";

    $passive_spotted = "<span class=passivevoice >(passive voice)</span>";

    $wordstoprocess = explode("*", $badstream);

    for ($x = 0; $x < count($wordstoprocess); $x++) {

      if(!empty($wordstoprocess[$x])) {
        $data = str_replace($wordstoprocess[$x], $passive_spotted . "<span class=passivevoice>" .  $collectedpassivewords . $wordstoprocess[$x] . $collectedpassivewords.  "</span>",$data);
      }

    }


    for ($x = 0; $x <= count(($wordstoprocess[$x])); $x++) {


    $data = str_replace( ucwords($wordstoprocess[$x]), $passive_spotted . "<span class=passivevoice >" .  $collectedpassivewords .  ucwords($wordstoprocess[$x]) . $collectedpassivewords . "</span>",$data);

    }


    $data = preg_replace('/[\r\n]+/i', "<br>", $data);


    return $data  ;
  }


  /**
  * Checks for bad words and surounds them in css
  *
  * @param String $data
  *   The cv being checked.
  *
  *   .   *
  * @return String $badstream
  *   The string data with found words surrounded in css.
  */

  public function cvprocessing_process_pronoun($data, $badstream) {

    $collectedbadword = "PPPP";

    $wordstoprocess = explode("*", $badstream);

    for ($x = 0; $x < count($wordstoprocess); $x++) {

      if(!empty($wordstoprocess[$x])) {

        $data = str_replace(" " .$wordstoprocess[$x] . " ","<span class = badword >" . $collectedbadword . $wordstoprocess[$x] .  $collectedbadword.  "</span>",$data);   }
    }


    for ($x = 0; $x < count($wordstoprocess); $x++) {


      if(!empty($wordstoprocess[$x])) {
        $data = str_replace(  ucwords($wordstoprocess[$x] . " "),"<span class = badword >" .  $collectedbadword .  ucwords($wordstoprocess[$x]) .  $collectedbadword . "</span>",$data);
      }
    }

    // detects end of line in cv etc an repleces then with spaces
    $data = preg_replace('/[\r\n]+/i', "<br>", $data);


    return $data .  $collectedbadword ;
  }


  /**
  * Checks for bad words and surounds them in css
  *
  * @param String $data
  *   The cv being checked.
  *
  *   .   *
  * @return String $badstream
  *   The string data with found words surrounded in css.
  */

  public function cvprocessing_process_phrases($data, $badstream) {

    $collectedbadword = "BBBB";

    $wordstoprocess = explode("*", $badstream);

    for ($x = 0; $x < count($wordstoprocess); $x++) {

      if(!empty($wordstoprocess[$x])) {
        $data = str_replace(" " .$wordstoprocess[$x] . " ","<span class = badword >" . $collectedbadword . $wordstoprocess[$x] .  $collectedbadword.  "</span>",$data);
      }

    }


    for ($x = 0; $x < count($wordstoprocess); $x++) {


      if(!empty($wordstoprocess[$x])) {
        $data = str_replace(  ucwords($wordstoprocess[$x] . " "),"<span class = badword >" .  $collectedbadword .  ucwords($wordstoprocess[$x]) .  $collectedbadword . "</span>",$data);
      }

    }

    // detects end of line in cv etc an repleces then with spaces
    $data = preg_replace('/[\r\n]+/i', "<br>", $data);


    return $data .  $collectedbadword ;
  }

}

