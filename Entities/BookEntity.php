<?php

namespace Entities;

class BookEntity
{
  private $id;
  private $title;
  private $description;
  private $rating;
  private $ISBN_13;
  private $ISBN_10;
  private $image;
  private $language;
  private $price;
  private $currency;
  private $buy_link;
  private $authorsIds;
  private $categoriesIds;
  private $authors;

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->{$key} = $value;
    }
  }

  /**
   * @return int
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param int $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription($description)
  {
    $this->description = $description;
  }

  /**
   * @return float
   */
  public function getRating()
  {
    return $this->rating;
  }

  /**
   * @param float $rating
   */
  public function setRating($rating)
  {
    $this->rating = $rating;
  }

  /**
   * @return string
   */
  public function getISBN13()
  {
    return $this->ISBN_13;
  }

  /**
   * @param string $ISBN_13
   */
  public function setISBN13($ISBN_13)
  {
    $this->ISBN_13 = $ISBN_13;
  }

  /**
   * @return string
   */
  public function getISBN10()
  {
    return $this->ISBN_10;
  }

  /**
   * @param string $ISBN_10
   */
  public function setISBN10($ISBN_10)
  {
    $this->ISBN_10 = $ISBN_10;
  }

  /**
   * @return string
   */
  public function getImage()
  {
    if (!$this->image)
      $this->image = "/images/default.jpeg";
    return $this->image;
  }

  /**
   * @param string $image
   */
  public function setImage($image)
  {
    $this->image = $image;
  }

  /**
   * @return string
   */
  public function getLanguage()
  {
    return $this->language;
  }

  /**
   * @param string $language
   */
  public function setLanguage($language)
  {
    $this->language = $language;
  }

  /**
   * @return float
   */
  public function getPrice()
  {
    return $this->price;
  }

  /**
   * @param float $price
   */
  public function setPrice($price)
  {
    $this->price = $price;
  }

  /**
   * @return string
   */
  public function getCurrency()
  {
    return $this->currency;
  }

  /**
   * @param string $currency
   */
  public function setCurrency($currency)
  {
    $this->currency = $currency;
  }

  /**
   * @return string
   */
  public function getBuyLink()
  {
    return $this->buy_link;
  }

  /**
   * @param string $buy_link
   */
  public function setBuyLink($buy_link)
  {
    $this->buy_link = $buy_link;
  }

  /**
   * @return array
   */
  public function getAuthorsIds()
  {
    return isset($this->authorsIds) ? $this->authorsIds : array();
  }

  /**
   * @return array
   */
  public function getCategoriesIds()
  {
    return isset($this->categoriesIds) ? $this->categoriesIds : array();
  }


  /**
   * @param array $authorsIds
   *   Authors Ids.
   */
  public function setAuthorsIds($authorsIds)
  {
    $this->authorsIds = $authorsIds;
  }

  /**
   * @param array $categoriesIds
   *   Categories Ids.
   */
  public function setCategoriesIds($categoriesIds)
  {
    $this->categoriesIds = $categoriesIds;
  }

  /**
   * @return array
   */
  public function getAuthors()
  {
    return isset($this->authors) ? $this->authors : array();
  }

  /**
   * @return array
   */
  public function getCategories()
  {
    return isset($this->categories) ? $this->categories : array();
  }

  public function jsonSerialize()
  {
    $array = array_map(function ($v) {
      return (is_null($v)) ? "" : $v;
    }, get_object_vars($this));
    return $array;
  }

  /**
   * @return string
   */
  public function getStarsHtml()
  {
    return gbooks_theme_generate_rating_stars($this->getRating());
  }
}