<?php

namespace Models;


use atk4\dsql\Expression;
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
   * @return array|\atk4\dsql\PDOStatement
   *
   * @throws \atk4\dsql\Exception
   */
  function save($term)
  {

    if (is_null($term->getVid())) {
      $query = $this->dsql_connection->dsql();
      $result = $query->table('vocabulary')
        ->where('vocabulary', '=', $term->getVocabulary())
        ->getRow();
      $term->setVid($result['vid']);
    }
    $tid = $term->getTid();
    if (isset($tid)) {
      $query = $this->dsql_connection->dsql();
      $result = $query->table('terms')
        ->set('vid', $term->getVid())
        ->set('name', $term->getName())
        ->where("tid", "=", $tid)
        ->update();
    } else {
      $query = $this->dsql_connection->dsql();
      $result = $query->table('terms')
        ->set('vid', $term->getVid())
        ->set('name', $term->getName())
        ->insert();
    }
    return $result;

  }

  /**
   * Get term by id.
   *
   * @param int $tid
   *
   * @return TermEntity
   * @throws \atk4\dsql\Exception
   */
  function get($tid)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query->table('terms')
      ->where('tid', '=', $tid)
      ->getRow();
    $term = NULL;
    if ($result) {
      $term = new TermEntity(array(
        "tid" => $result['tid'],
        "vid" => $result['vid'],
        "name" => $result['name']
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
   *
   * @throws \atk4\dsql\Exception
   */
  function findByVocabularyAndName($vocabulary, $name)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query
      ->table('terms', 't')
      ->join('vocabulary v', new Expression("t.vid=v.vid"), "inner")
      ->where('v.vocabulary', "LIKE", $vocabulary)
      ->where('t.name', "LIKE", $name)
      ->getRow();
    $term = NULL;
    if ($result) {
      $term = new TermEntity(array(
        "tid" => $result['tid'],
        "vid" => $result['vid'],
        "name" => $result['name'],
        "vocabulary" => $result['vocabulary']
      ));
    }
    return $term;
  }
}