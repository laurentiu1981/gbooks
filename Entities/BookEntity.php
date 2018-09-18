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

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->{$key} = $value;
    }
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setDescription($description)
  {
    $this->description = $description;
  }

  public function getRating()
  {
    return $this->rating;
  }

  public function setRating($rating)
  {
    $this->rating = $rating;
  }

  public function getISBN13()
  {
    return $this->ISBN_13;
  }

  public function setISBN13($ISBN_13)
  {
    $this->ISBN_13 = $ISBN_13;
  }

  public function getISBN10()
  {
    return $this->ISBN_10;
  }

  public function setISBN10($ISBN_10)
  {
    $this->ISBN_10 = $ISBN_10;
  }

  public function getImage()
  {
    return $this->image;
  }

  public function setImage($image)
  {
    $this->image = $image;
  }

  public function getLanguage()
  {
    return $this->language;
  }

  public function setLanguage($language)
  {
    $this->language = $language;
  }

  public function getPrice()
  {
    return $this->price;
  }

  public function setPrice($price)
  {
    $this->price = $price;
  }

  public function getCurrency()
  {
    return $this->currency;
  }

  public function setCurrency($currency)
  {
    $this->currency = $currency;
  }

  public function getBuyLink()
  {
    return $this->buy_link;
  }

  public function setBuyLink($buy_link)
  {
    $this->buy_link = $buy_link;
  }

}