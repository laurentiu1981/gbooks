<?php

error_reporting(E_ALL ^ E_NOTICE);

// check if there is at least 1 argument
if ($argc === 1) {
  trigger_error('you have to give at least 1 argument');
  exit();
} else if ($argc > 3) {
  trigger_error('you can give at most 2 arguments');
  exit();
}
//set category
if ($argv[1] !== '') {
  $category = $argv[1];
} else {
  trigger_error('you have to give at least 1 argument');
}
//set author
if (isset($argv[2])) {
  $author = $argv[2];
} else
  $author = "";

$startIndex = 0;
$resultArray = [];

$url = createRequestURL($author, $category, $startIndex);
$array = get($url);
$nrItems = $array['totalItems'];

while ($startIndex < $nrItems - 41) { //< $nrItems
  $items = $array['items'];
  $resultArray = addToArray($resultArray, $items);
  $startIndex += 40;

  $url = createRequestURL($author, $category, $startIndex);
  $array = get($url);
}

print_r("finalArrayLength: " . count($resultArray) . "\n");
print_r("first Item: " . $resultArray[0]['title'] . "\n");
print_r("url: " . $url);
print_r("nrItems: " . $nrItems . "\n");

return $resultArray;

/**
 * create url.
 *
 * @param string $author
 *   Author name.
 * @param string $category
 *   Category name.
 * @param number $startIndex
 *   Start index of item to get
 *
 * @return string
 *   url.
 */
function createRequestURL($author, $category, $startIndex)
{
  $url = 'https://www.googleapis.com/books/v1/volumes?q=""';
  $url .= 'inauthor:"' . $author . '"';
  $url .= 'subject:' . $category;
  $url .= '&key=' . 'AIzaSyBrfRz440kh3BtxxpgfumpOY3IX7olF6xw';
  $url .= '&maxResults=40&startIndex=' . $startIndex;
  return $url;
}

/**
 * Add ann array of items to result array.
 *
 * @param array $resultArray
 *   Array to which items are added.
 * @param array $items
 *   Items to select.
 *
 * @return array
 *   Array with all items.
 */
function addToArray($resultArray, $items)
{
  foreach ($items as $element) {
    $industryId = $element['volumeInfo']['industryIdentifiers'];
    if ($industryId[0]['type'] === "ISBN_13") {
      $ISBN_13 = $industryId[0]['identifier'];
      $ISBN_10 = $industryId[1]['identifier'];
    } else {
      $ISBN_10 = $industryId[0]['identifier'];
      $ISBN_13 = $industryId[1]['identifier'];
    }
    $resultArray[] = array(
      "title" => $element['volumeInfo']['title'],
      "authors" => $element['volumeInfo']['authors'],
      //"description"=>$element['volumeInfo']["description"],
      "ISBN_13" => $ISBN_13,
      "ISBN_10" => $ISBN_10,
      "categories" => $element['volumeInfo']['categories'],
      "rating" => $element['volumeInfo']['averageRating'],
      "image" => $element['volumeInfo']['imageLinks']['thumbnail'],
      "language" => $element['volumeInfo']['language'],
      "price" => $element['saleInfo']['retailPrice']['amount'],
      "currency" => $element['saleInfo']['retailPrice']['currencyCode'],
      "buy_link" => $element['saleInfo']['buyLink'],
    );
  }
  return $resultArray;
}


/**
 * Get request.
 *
 * @param array $url
 *   url for get request.
 *
 * @return array
 *   The get response.
 */
function get($url)
{
  $cSession = curl_init();
  curl_setopt($cSession, CURLOPT_URL, $url);
  curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($cSession, CURLOPT_HEADER, "Content-Type: application/json");
  curl_setopt($cSession, CURLOPT_FAILONERROR, true);


  $json = curl_exec($cSession);

  if (curl_error($cSession)) {
    $error_msg = curl_error($cSession);
    trigger_error("\n err: " . $error_msg);
    exit();
  }

  $array = json_decode($json, true);
  curl_close($cSession);

  return $array;
}

//php books_script.php "history" "Ana"