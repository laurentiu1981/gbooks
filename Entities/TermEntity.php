<?php

namespace Entities;


class TermEntity
{
  private $id = NULL;
  private $vocabulary;
  private $name;

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->{$key} = $value;
    }
  }


  /**
   * @return string
   */
  public function getVocabulary()
  {
    return $this->vocabulary;
  }

  /**
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * @return mixed
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * @param mixed $id
   */
  public function setId($id)
  {
    $this->id = $id;
  }

  /**
   * @param mixed $vocabulary
   */
  public function setVocabulary($vocabulary)
  {
    $this->vocabulary = $vocabulary;
  }

  /**
   * @param mixed $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }


}