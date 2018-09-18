<?php

namespace scripts;

class BooksAPI
{
  private $startIndex;
  private $resultArray;
  private $author;
  private $category;

  public function __construct($author, $category)
  {
    $this->author = $author;
    $this->category = $category;
    $this->startIndex = 0;
    $this->resultArray = [];
  }

  /**
   * Collect all data
   *
   * @return array
   *   array of books.
   */
  function getBooks()
  {
    $url = $this->createRequestURL();
    $array = $this->get($url);
    $nrItems = $array['totalItems'];
    while ($this->startIndex < $nrItems - 41) { //< $nrItems
      $items = $array['items'];
      $this->resultArray = $this->addToArray($items);
      $this->startIndex += 40;
      $url = $this->createRequestURL();
      $array = $this->get($url);
      $nrItems = $array['totalItems'];
    }
    return $this->resultArray;
  }

  /**
   * create url.
   *
   * @return string
   *   url.
   */
  function createRequestURL()
  {
    $url = 'https://www.googleapis.com/books/v1/volumes?q=""';
    $url .= 'inauthor:"' . urlencode($this->author) . '"';
    $url .= 'subject:' . urlencode($this->category);
    $url .= '&key=' . 'AIzaSyBrfRz440kh3BtxxpgfumpOY3IX7olF6xw';
    $url .= '&maxResults=40&startIndex=' . urlencode($this->startIndex);

    return $url;
  }

  /**
   * Add an array of items to result array.
   *
   * @param array $items
   *   Items to select.
   *
   * @return array
   *   Array with all items.
   */
  function addToArray($items)
  {
    foreach ($items as $element) {
      $item = array();
      $volumeInfo = !empty($element['volumeInfo']) ? $element['volumeInfo'] : array();
      if ($volumeInfo) {
        $item["title"] = !empty($volumeInfo['title']) ? $volumeInfo['title'] : NULL;
        $item["authors"] = !empty($volumeInfo['authors']) ? $volumeInfo['authors'] : array();
        $item["description"] = !empty($volumeInfo['description']) ? $volumeInfo['description'] : NULL;
        $industryIdentifiers = !empty($volumeInfo['industryIdentifiers']) ? $volumeInfo['industryIdentifiers'] : NULL;
        if ($industryIdentifiers) {
          $ISBN = !empty($industryIdentifiers[0]) ? $industryIdentifiers[0]['type'] : NULL;
          if ($ISBN === "ISBN_13")
            $item["ISBN_13"] = $industryIdentifiers[0]['identifier'];
          else if ($ISBN === "ISBN_10")
            $item["ISBN_10"] = $industryIdentifiers[0]['identifier'];
          $ISBN = !empty($industryIdentifiers[1]) ? $industryIdentifiers[1]['type'] : NULL;
          if ($ISBN === "ISBN_10")
            $item["ISBN_10"] = $industryIdentifiers[1]['identifier'];
          else if ($ISBN === "ISBN_13")
            $item["ISBN_13"] = $industryIdentifiers[1]['identifier'];
        }
        $item["categories"] = !empty($volumeInfo['categories']) ? $volumeInfo['categories'] : NULL;
        $item["rating"] = !empty($volumeInfo['averageRating']) ? $volumeInfo['averageRating'] : NULL;
        $image = !empty($volumeInfo['imageLinks']) ? $volumeInfo['imageLinks'] : NULL;
        $item["image"] = !empty($image['thumbnail']) ? $image['thumbnail'] : NULL;
        $item["language"] = !empty($volumeInfo['language']) ? $volumeInfo['language'] : NULL;
      }
      $saleInfo = !empty($element['saleInfo']) ? $element['saleInfo'] : array();
      if ($saleInfo) {
        $bookItem['price'] = !empty($saleInfo['retailPrice']) ? $saleInfo['retailPrice']['amount'] : NULL;
        $bookItem['currency'] = !empty($saleInfo['retailPrice']) ? $saleInfo['retailPrice']['currencyCode'] : NULL;
        $bookItem['buyLink'] = !empty($saleInfo['buyLink']) ? $saleInfo['buyLink'] : NULL;
      }
      $this->resultArray[] = $item;
    }
    return $this->resultArray;
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

}
