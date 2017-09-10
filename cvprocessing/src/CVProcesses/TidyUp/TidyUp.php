<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\TidyUp\TidyUp
*/


namespace Drupal\cvprocessing\CVProcesses\TidyUp;

/**
 * Final tidy up of cv after processing
 */
class TidyUp {

  /**
  *
  * @param String $cv
  *   The cv being checked.
  *
  *   .   *
  * @return String $finalcv
  *   The finally prepared cv ready for display
  */
  public function cvprocessing_finaltidyup($cv) {

    //  replaces backslash palceholder 'backslashes' with backslashes \
    $string = $cv;
    $pattern = '/backslashes/i';
    $replacement = '\\';
    $finalcv = preg_replace($pattern, $replacement, $string);

    //  replaces forward slash palceholder 'forwardslashes' with forwardslashes /
    $string = $finalcv;
    $pattern = '/forwardslashes/i';
    $replacement = '/';
    $finalcv = preg_replace($pattern, $replacement, $string);

    // removes marker characters added during word spotting processes
    $finalcv = preg_replace( '/([?]{4}|[#]{4}|[P]{4}|[£]{4}|[B]{4}|[p]{4}|[b]{4})/', " ",  $finalcv);

    //  replaces i  with I in stats display
    $string = $finalcv;
    $pattern = '/(\s)(i)(\s)/i';
    $replacement = ' I ';
    $finalcv = preg_replace($pattern, $replacement, $string);

    return  $finalcv;

  }

}

