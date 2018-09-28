<?php

namespace scripts;

use Entities\BookEntity;
use Entities\TermEntity;
use Models\BookModel;
use Models\TermModel;

class BooksAPI
{
  private $startIndex;
  private $resultArray;
  private $author;
  private $category;
  private $title;

  public function __construct($title, $author, $category)
  {
    $this->title = $title;
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
    $nrItems = NULL;
    while (is_null($nrItems) || $this->startIndex < $nrItems) {
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
    $url = 'https://www.googleapis.com/books/v1/volumes?q="' . urlencode($this->title) . '"';
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
        $item['price'] = !empty($saleInfo['retailPrice']) ? $saleInfo['retailPrice']['amount'] : NULL;
        $item['currency'] = !empty($saleInfo['retailPrice']) ? $saleInfo['retailPrice']['currencyCode'] : NULL;
        $item['buy_link'] = !empty($saleInfo['buyLink']) ? $saleInfo['buyLink'] : NULL;
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

  /**
   * Saves each term in authors/categories list into the database if it doesn't already exist.
   *
   * @param array $termList
   *    Array of strings representing author/category names.
   *
   * @param string $type
   *    Type of the terms that are going to be stored into the database: either authors or categories.
   *
   * @return array
   *    Array of term IDs for the authors/categories saved
   */
  function saveTerms($termList, $type)
  {
    $termModel = new TermModel();
    $termArray = array();
    if (is_array($termList)) {
      foreach ($termList as $name) {
        $term = $termModel->findByVocabularyAndName($type, $name);
        if ($term === NULL) {
          $newTerm = new TermEntity(array('vocabulary' => $type, 'name' => $name));
          $tid = $termModel->save($newTerm);
          $termArray[] = $tid;
        } else {
          $termArray[] = $term->getTid();
        }
      }
    }
    return $termArray;
  }


  /**
   * Saves books into the database.
   */
  function saveBooksToDatabase()
  {
    $books = $this->getBooks();
    $bookModel = new BookModel();
    foreach ($books as $book) {
      if ($bookModel->checkBook($book))
        continue;
      $book['authorsIds'] = $this->saveTerms($book['authors'], 'authors');
      $book['categoriesIds'] = $this->saveTerms($book['categories'], 'categories');
      unset($book['authors']);
      unset($book['categories']);
      $bookEntity = new BookEntity($book);
      $bookModel->save($bookEntity);
    }
  }
}
