<?php

namespace Models;


use Entities\TermEntity;

class TermModel extends BasicModel
{

  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Save term.
   *
   * @param TermEntity $term
   *
   * @return bool
   */
  function save($term)
  {
    if (is_null($term->getVid())) {
      $sql = 'SELECT vid FROM vocabulary WHERE vocabulary LIKE ?';
      $data = array($term->getVocabulary());
      $statement = $this->executeStatement($sql, $data);
      $term->setVid($statement->fetchObject()->vid);
    }
    $tid = $term->getTid();
    if (isset($tid)) {
      $sql = 'UPDATE terms SET vid=?, name=? WHERE tid=?';
      $data = array($term->getVid(), $term->getName(), $tid);
      $statement = $this->executeStatement($sql, $data);
    } else {
      $sql = 'INSERT INTO terms (vid, name) VALUES (?, ?)';
      $data = array($term->getVid(), $term->getName());
      $statement = $this->executeStatement($sql, $data);
    }
    return $statement;

  }

  /**
   * Get term by id.
   *
   * @param int $tid
   *
   * @return TermEntity
   */
  function get($tid)
  {
    $sql = 'SELECT tid,vid,name FROM terms WHERE tid=?';
    $data = array($tid);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $term = NULL;
    if ($row) {
      $term = new TermEntity(array(
        "tid" => $tid,
        "vid" => $row->vid,
        "name" => $row->name,
      ));
    }
    return $term;
  }

  /**
   * Find a term by vocabulary and name.
   *
   * @param string $vocabulary
   *    vocabulary name
   * @param string $name
   *    term name
   *
   * @return TermEntity
   */
  function findByVocabularyAndName($vocabulary, $name)
  {
    $sql = 'SELECT T.tid,T.vid,T.name,V.vocabulary 
            FROM terms AS T INNER JOIN vocabulary AS V ON T.vid=V.vid 
            WHERE V.vocabulary LIKE ? AND T.name LIKE ? ';
    $data = array($vocabulary, $name);
    $statement = $this->executeStatement($sql, $data);
    $row = $statement->fetchObject();
    $term = NULL;
    if ($row) {
      $term = new TermEntity(array(
        "tid" => $row->tid,
        "vid" => $row->vid,
        "vocabulary" => $row->vocabulary,
        "name" => $row->name,
      ));
    }
    return $term;
  }
}