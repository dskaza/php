<?php

class ItemsInBoxes
{
  public function getAppropriateBoxes($items, $boxes)
  {
    $choosen_boxes = array();

    foreach( $items as $item_id => $needed_quantity )
    {
      foreach( $boxes as $boxId => $products )
      {
        if( isset($boxes[$boxId][$item_id]) )
        {
          $choosen_boxes[] = $boxId;
        }
      }
    }

    return array_values(array_unique($choosen_boxes));
  }





  public function run(&$items, &$needed_boxes, &$boxes)
  {
    $boxIndex = array_rand($needed_boxes, 1);
    $boxId = $needed_boxes[$boxIndex];

    $box = $boxes[$boxId];
    $required_boxes = 0;
    
    foreach( $box as $product_id => $available_quantity )
    {
      // if box has item that we don't need skip it
      if( !isset($items[$product_id]) )
        continue;

      $needed_quantity = $items[$product_id];

      // item quantity has already been satisfied, but the box has this item
      // we can skip this product then
      if( $needed_quantity < 1 )
      {
        continue;
      }
      
      $required_boxes_ = ceil( $needed_quantity / $available_quantity );

      if( $required_boxes_ > $required_boxes )
        $required_boxes = $required_boxes_;

      // decrease item to 0
      $items[$product_id] = 0;
    }

    // we took everything that we need from this box, now 
    // we can delete it
    unset($needed_boxes[$boxIndex]);

    // re-index
    $needed_boxes = array_values($needed_boxes);

    return array($boxId => $required_boxes);
  }




  public function allDone($items)
  {
    foreach( $items as $item_id => $needed_quantity )
    {
      if( $needed_quantity > 0 )
      {
        return false;
      }
    }

    return true;
  }




  public function getFinalResult($result)
  {
    $final_result = array();

    foreach( $result as $index => $box )
    {
      foreach( $box as $boxId => $needed_boxes )
      {
        if( $needed_boxes > 0 )
        {
          $final_result[$boxId] = $needed_boxes;
        }
      }
    }

    return $final_result;    
  }
}


// ---------------------------------------------------------------------------



//include("algorithm.php");

/*
items array is [$itemId => $neededQuantity]
This array has the list of items and quantities which I need to buy.
*/
//$items = require_once('items.php');

$items = array (
  '3649718740' => '7',
  '4063792958' => '10',
  '4063793009' => '5',
  '4715174217' => '8',
  '4715443375' => '7',
  '4715467975' => '12',
  '4715758202' => '2',
  '4715758349' => '11',
  '4715922573' => '6',
  '6028082746' => '12',
  '6028082753' => '11',
  '6028093506' => '7',
  '6028116373' => '10',
  '6028116380' => '8',
  '6028521894' => '1',
  '6028571080' => '4',
  '6028598773' => '7',
  '6028598803' => '3',
  '6028598810' => '13',
  '6028606706' => '9',
  '6028606751' => '3',
  '6028600681' => '12',
  '6028600704' => '6',
  '6028608182' => '2',
  '6028715620' => '3',
  '6028651300' => '9',
  '6028651324' => '8',
  '6028651355' => '7',
  '6028651621' => '6',
  '6028695700' => '5',
  '6028696608' => '9',
  '6028696615' => '7',
  '6028757095' => '10',
  '6028793024' => '12'
);
// 34 items

/*
boxes array is $boxId => [$itemId => $quantityInBox]
This array has the catalog of boxes available to buy.
*/
//$boxes = require_once('boxes.php');

$boxes = array (
  '4715223106' =>
      array (
        '3649718740' => '3',
      ),
  '4715707187' =>
      array (
        '3649718740' => '3',
        '6028082753' => '1',
      ),
  '6028776744' =>
      array (
        '4063792958' => '3',
        '4063793009' => '5',
      ),
  '4715174156' =>
      array (
        '4715174217' => '1',
      ),
  '4715443351' =>
      array (
        '4715443375' => '1',
        '4063792958' => '1',
        '4063793009' => '3',
        '6028082746' => '1',
      ),
  '4715467968' =>
      array (
        '4715467975' => '6',
      ),
  '4715758141' =>
      array (
        '4715758202' => '1',
      ),
  '4715758288' =>
      array (
        '4715758349' => '1',
      ),
  '4715922542' =>
      array (
        '4715922573' => '3',
      ),
  '6028082685' =>
      array (
        '6028082746' => '4',
        '6028082753' => '2',
      ),
  '6028093490' =>
      array (
        '6028093506' => '12',
        '4715467975' => '2',
      ),
  '6028116335' =>
      array (
        '6028116373' => '3',
        '6028116380' => '2',
      ),
  '6028521849' =>
      array (
        '6028521894' => '2',
      ),
  '6028573596' =>
      array (
        '6028571080' => '4',
        '6028116373' => '7',
      ),
  '6028598759' =>
      array (
        '6028598773' => '1',
        '6028598803' => '2',
        '6028598810' => '1',
      ),
  '6028600636' =>
      array (
        '6028600681' => '2',
        '6028600704' => '1',
      ),
  '6028606690' =>
      array (
        '6028606706' => '1',
        '6028606751' => '4',
      ),
  '6028608168' =>
      array (
        '6028608182' => '3',
      ),
  '6028651294' =>
      array (
        '6028651300' => '1',
        '6028651324' => '3',
        '6028651355' => '1',
        '6028608182' => '1',
      ),
  '6028651577' =>
      array (
        '6028651621' => '2',
        '6028793024' => '6',
      ),
  '6028695656' =>
      array (
        '6028695700' => '2',
      ),
  '6028696561' =>
      array (
        '6028696608' => '3',
        '6028696615' => '2',
      ),
  '6028715705' =>
      array (
        '6028715620' => '10',
      ),
  '6028757040' =>
      array (
        '6028757095' => '2',
      ),
  '6028792980' =>
      array (
        '6028793024' => '1',
      ),
);
// 25 boxes


//-----------------------------------------------------------------


/*
We have boxes which have N items in it with N quantity. Items can be in 1 or more boxes.
How many boxes from which box do I need to buy, to satisfy the needed item quantities?
The provided data should give back: needed box quantity and which items are in the box.
What would be the best combination to have least amount of boxes.
An OOP approach would add more point to the test.
*/

echo "We have" . count($items) . "items <br>"; 


$r = new ItemsInBoxes();

// traverse throught all items and get array of boxes in which they are
//
$needed_boxes = $r->getAppropriateBoxes($items, $boxes);


echo '<pre>' . print_r($needed_boxes) . '</pre><br>';



$result = array();
$count = count($needed_boxes);
	
while( $count > 0 )
{
  $result[] = $r->run($items, $needed_boxes, $boxes);

  // if all items are satisfied we have solution break
  if( $r->allDone($items) )
  {
    // We have found solution earlier 
    break;
  }
  $count = count($needed_boxes);
}


$final_result = $r->getFinalResult($result);

$box_count = 0;
foreach( $final_result as $boxId => $num_of_boxes)
  $box_count += $num_of_boxes;


echo "Amount of boxes to satisfy required items is: " . $box_count . PHP_EOL . '<br>';

echo "Boxes with number of boxes to buy and items in it are listed below in format BoxId => Amount[list of Items] : \n\n" . '<br>';

foreach( $final_result as $boxId => $num_of_boxes )
{
  echo $boxId . " => " . $num_of_boxes . "   [";

  foreach ($boxes[$boxId] as $item_id => $quantity)
  {
    echo $item_id . ", ";
  }
  echo "]" . PHP_EOL  . '<br>';
}
