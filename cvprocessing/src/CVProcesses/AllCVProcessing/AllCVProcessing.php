<?php

/**
* @file
* Contains \Drupal\cvprocessing\CVProcesses\AllCVProcessing\AllCVProcessing
*/

namespace Drupal\cvprocessing\CVProcesses\AllCVProcessing;

use Drupal\cvprocessing\CVProcesses\SpotGood\SpotGoodWords;

use Drupal\cvprocessing\CVProcesses\Spot\Spot;

use Drupal\get_streams\GetStreamsService\GetStreams;

use Drupal\cvprocessing\CVProcesses\PassiveVoice\PassiveVoice;

/**
 * Conducts the processing of the cv using streams and various services
 */
class AllCVProcessing {

  /**
   * The service which gets streams
   *
   * @var Drupal\get_streams\GetStreamsService\GetStreams
   */
  protected $streams;

  /**
   * The  service which processes good words
   *
   * @var  Drupal\cvprocessing\CVProcesses\SpotGood\SpotGoodWords;
   */
  protected $spotgoodwords;

  /**
   * The service which processes badwords
   *
   * @var Drupal\cvprocessing\CVProcesses\Spot\Spot
   */
   protected $spot;

  /**
   * The service which processes passive words.
   *
   * @var \Drupal\cvprocessing\CVProcesses\PassiveVoice\PassiveVoice
   */
  protected $passivevoice;


  /**
  * Constructs a AllCVProcessing object.
  *
  * @param Drupal\cvprocessing\CVProcesses\SpotGood\SpotGoodWords $spotgoodwords
  *   The service which processes good words
  *
  * @param Drupal\cvprocessing\CVProcesses\Spot\Spot $spot
  *   The service which processes bad word, phrases and pronouns
  *
  ** @param Drupal\get_streams\GetStreamsService\GetStreams $streams
  *   The service which gets streams of words
  *
  * @param Drupal\cvprocessing\CVProcesses\PassiveVoice\PassiveVoice
  *   The service which gets the stream of passive voice terms
  *
  */
  public function __construct(SpotGoodWords $spotgoodwords, Spot $spot, GetStreams $streams, PassiveVoice $passivevoice) {
    $this->spotgoodwords = $spotgoodwords;
    $this->spotbad = $spot;
    $this->streams = $streams;
    $this->passivevoice = $passivevoice;
  }

  public function allcvprocessing($data) {

    $passive = $this->passivevoice->makeallstreams();

    // Puts spaces either side of .,:: so that adjacent words can be processed
    $data  =  $this->spotbad->cvprocessing_process_passive($data, $passive);
    // Spots good words
    $data  =  $this->spotgoodwords->goodprocess($data);

    $badwordtofind = trim($this->streams->generateStream("bad word") );

    $badphrasetofind = trim($this->streams->generateStream("bad phrase") );

    $badprounoun = trim($this->streams->generateStream("pronoun") );

    $data  =  $this->spotbad->cvprocessing_process($data, $badwordtofind);

    $data  =  $this->spotbad->cvprocessing_process_phrases($data, $badphrasetofind);

    $data  =  $this->spotbad->cvprocessing_process_pronoun($data, $badprounoun);

    return $data ;
  }
}

