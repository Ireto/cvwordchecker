<?php

namespace Drupal\get_streams\Controller;

use Symfony\Component\HttpFoundation\Response;

use Drupal\Core\Controller\ControllerBase;

use Drupal\get_streams\GetStreamsService\GetStreams;

use Symfony\Component\DependencyInjection\ContainerInterface;


class GetStreamsController extends ControllerBase {


  private $streamGenerator;


  /**
  * Constructs a GetStreamsController object.
  *
  * @param $streamGenerator Drupal\get_streams\GetStreamsService\GetStreams
  *   The service which gets the GetStreams object which is used to generate various stream types
  *
  */
  public function __construct( GetStreams $streamGenerator) {
    $this->streamGenerator = $streamGenerator;
  }


  /**
  * Returns all the words
  *
  * @return String
  *
  */
  public function streams() {

    $nids = \Drupal::entityQuery('node')->condition('type','word')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    $titles = "";

    foreach ($nodes as $key => $value) {
      $title =  $value->title->value;

      $term = \Drupal\taxonomy\Entity\Term::load($value->get('field_word_type')->target_id)->getName();

      $titles.= $title . ' ' . $term . '<br>';

    }

    return new Response( $titles);
  }


  /**
  * Returns all the good words
  *
  * @return String
  *
  */

  public function streams_good() {

    $goodwords =  $this->streamGenerator->generateStream("good word");

    return new Response( $goodwords);
  }

  /**
  * Returns all pronouns
  * @return String
  *
  */
  public function streams_pronouns() {

    $pronouns =  $this->streamGenerator->generateStream("pronoun");

    return new Response( $pronouns);
  }


  /**
  * Returns all bad words
  *
  * @return String
  *
  */
  public function streams_bad() {

    $badwords =  $this->streamGenerator->generateStream("bad word");

    return new Response( $badwords);
  }


  /**
  * Returns all the bad phrases
  *
  * @param String $type_of_stream
  *
  * @return String
  *
  */

  public function streams_bad_phrases() {

    $badphrases =  $this->streamGenerator->generateStream("bad phrase");

    return new Response( $badphrases);
  }


  public static function create(ContainerInterface $container) {
    $streamGenerator = $container->get('get_streams.stream_generator');
    return new static($streamGenerator);
  }



}
