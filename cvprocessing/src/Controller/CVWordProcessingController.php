<?php

/**
* @file
* Contains \Drupal\cvprocessing\Controller\CVWordProcessingController
*/

namespace Drupal\cvprocessing\Controller;

use Drupal\Core\Controller\ControllerBase;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

use Drupal\cvprocessing\CVProcesses\AllCVProcessing\AllCVProcessing;

use Drupal\cvprocessing\CVProcesses\DisplayData\DisplayData;

use Drupal\cvprocessing\CVProcesses\TidyUp\TidyUp;

use Drupal\cvprocessing\CVProcesses\RepeatWordCounter\RepeatWordCounter;

class CVWordProcessingController extends ControllerBase {

  /**
   * The Drupal\cvprocessing\CVProcesses\AllCVProcessing\AllCVProcessing object.
   *
   * @var \Drupal\cvprocessing\CVProcesses\AllCVProcessing\AllCVProcessing
   */
  protected $allcvprocessing;

  /**
   * The Display data.
   *
   * @var Drupal\cvprocessing\CVProcesses\DisplayData\DisplayData
   */
  protected $displaydata;

  /**
   * The tidy up service used to clean up the final cv after processing.
   *
   * @var Drupal\cvprocessing\CVProcesses\TidyUp\TidyUp
   */
  protected $tidyup;

  /**
   * The repeat word counter service object used todisplay repeated words in the cv.
   *
   * @var Drupal\cvprocessing\CVProcesses\RepeatWordCounter\RepeatWordCounter
   */
  protected $repeatwordcounter;

  /**
  * Constructs a CVWordProcessingController object.
  *
  * @param Drupal\cvprocessing\CVProcesses\AllCVProcessing\AllCVProcessing $allcvprocessing
  *   The service which calls other services to process the cv
  *
  */
  public function __construct(AllCVProcessing $allcvprocessing, DisplayData $displaydata, TidyUp $tidyup, RepeatWordCounter $repeatwordcounter ) {

    $this->allcvprocessing = $allcvprocessing;

    $this->displaydata = $displaydata;

    $this->tidyup = $tidyup;

    $this->repeatwordcounter = $repeatwordcounter;
  }

  /**
  * Returns all the words of a given type
  *
  * @param String  $cvprocessing
  *
  *  The actual submitted cv
  * @return array
  *
  */
  public function processing($cvprocessing) {

    // calculates repeated words in teh cv
    $repeatwords = $this->repeatwordcounter->cvprocessing_repeatwordcounter($cvprocessing);

    $double  =  $this->allcvprocessing->allcvprocessing($cvprocessing);

    //Adds statistical display to main cv output
    $statsdisplay = $this->displaydata->makedisplays($double);

   // performs final tidy up on statistical display before display
    $statsdisplay  = $this->tidyup->cvprocessing_finaltidyup($statsdisplay );

    // performs final tidy up on processed cv before display
    $double = $this->tidyup->cvprocessing_finaltidyup($double);


    $processcompleted =  array(
      '#type' => 'markup',

      '#markup' => $this->t( "<table><tr> " . "<td>" . $double . "</td><td>" . $statsdisplay. "</td>" . "<tr></table>" ),

    );

    // Attaches  css library  to the output
    /*$processcompleted[]['#attached']['library'][] = 'cvprocessing/cvprocessing.processing';
    return $processcompleted; */


    // makes array containing data
    $data = array(
      'cv' =>  $double ,
      'display' =>  $statsdisplay,
      'repeatwords' =>  $repeatwords,


    );

    $response = new JsonResponse();

    $response->setData($data);

    // returns the processed cv and statistical data as a json object
    return $response;
  }


  public static function create(ContainerInterface $container) {

    // Gets hold of service to process the cv
    $allcvprocessing = $container->get('cvprocessing.allprocessing');

    $displaydata = $container->get('cvprocessing.displaydata');

    $tidyup = $container->get('cvprocessing.tidyup');

    $repeatwordcounter = $container->get('cvprocessing.repeatwordcounter');

    return new static( $allcvprocessing, $displaydata, $tidyup, $repeatwordcounter );

  }

}

/*

use the following files to use this api:


<!DOCTYPE html>
<html>
<body>

<form action="http://localhost/hope.php"  method="post">
  <textarea name="message" rows="10" cols="30">The cat was playing in the garden.</textarea>
  <br>
  <input type="submit">
</form>

</body>
</html>


<?php


$tiger = $_POST["message"];





 echo file_get_contents( "http://localhost/drupal888/cvprocess/" .  urlencode(  $tiger ) );

?>









*/
