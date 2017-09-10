<?php
namespace Drupal\get_streams\GetStreamsService;/**


/**
* Returns all the words of a given type
*
*/

class GetStreams {

  /**
  * Returns all the words of a given type
  *
  * @param String $type_of_stream
  *
  * @return String
  *
  */
  public function generateStream($type_of_stream) {

    $nids = \Drupal::entityQuery('node')->condition('type','word')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    $titles = "";

    foreach ($nodes as $key => $value) {
      $title =  $value->title->value;

      $term = \Drupal\taxonomy\Entity\Term::load($value->get('field_word_type')->target_id)->getName();

      if($term == $type_of_stream) {

        $titles.= $title . '*' ;
      }

    }

    return  $titles;
  }
}
