<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\AllCVProcessing\DotsToDotWithSpaces\DotProcess
*/

namespace Drupal\cvprocessing\CVProcesses\DotsToDotWithSpaces;

/**
 * Puts spaces either side of .,:: so that adjacent words can be processed
 */
class DotProcess {

  /**
  * Puts spaces either side of .,:: so that adjacent words can be processed
  *
  * @param String $data
  *   The data to be processed.
  *
  * @return String
  *   The processed data
  *
  */
  public function processthedots($data) {

    $pattern = '/([.,:;]+)/mi';
    $replacement = " " . '$1' . " " ;

    $data = preg_replace($pattern , $replacement, $data);
    return  $data ;
  }

}
