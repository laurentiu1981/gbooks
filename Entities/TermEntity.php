<?php

namespace Entities;


class TermEntity
{
  private $tid = NULL;
  private $vid = NULL;
  private $name;
  private $vocabulary;

  public function __construct($params)
  {
    foreach ($params as $key => $value) {
      $this->{$key} = $value;
    }
  }

  /**
   * getter for $tid
   *
   * @return int
   *      $tid
   */
  public function getTid()
  {
    return $this->tid;
  }

  /**
   * setter for $tid
   *
   * @param int $tid
   */
  public function setTid($tid)
  {
    $this->tid = $tid;
  }

  /**
   * getter for $vid
   *
   * @return int
   *    $vid
   */
  public function getVid()
  {
    return $this->vid;
  }

  /**
   * setter for $vid
   *
   * @param int
   *    $vid
   */
  public function setVid($vid)
  {
    $this->vid = $vid;
  }

  /**
   * getter for $name
   *
   * @return string
   *    $name
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * setter for $name
   *
   * @param string
   *    $name
   */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
   * getter for $vocabulary
   *
   * @return string
   *  $vocabulary
   */
  public function getVocabulary()
  {
    return $this->vocabulary;
  }

  /**
   * setter for $vocabulary
   *
   * @param string $vocabulary
   */
  public function setVocabulary($vocabulary)
  {
    $this->vocabulary = $vocabulary;
  }


}