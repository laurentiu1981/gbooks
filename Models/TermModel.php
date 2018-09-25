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
      $query->table('terms')
        ->set('vid', $term->getVid())
        ->set('name', $term->getName())
        ->where("tid", "=", $tid)
        ->update();
    } else {
      $query = $this->dsql_connection->dsql();
      $query->table('terms')
        ->set('vid', $term->getVid())
        ->set('name', $term->getName())
        ->insert();
      $tid = $this->dsql_connection->lastInsertID();
    }
    return $tid;
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
      ->where('v.vocabulary', '=', $vocabulary)
      ->where('t.name', '=', $name)
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

  /**
   * Get term names by vocabulary
   *
   * @param string $vocabulary
   *    Vocabulary name.
   *
   * @return array of strings
   *
   * @throws \atk4\dsql\Exception
   */
  function getTermNamesByVocabulary($vocabulary)
  {
    $query = $this->dsql_connection->dsql();
    $result = $query
      ->field('t.name')
      ->field('t.tid')
      ->table('terms', 't')
      ->join('vocabulary v', new Expression("t.vid=v.vid"), "inner")
      ->where('v.vocabulary', '=', $vocabulary)
      ->get();
    $terms = array();
    foreach($result as $item) {
      $terms[$item['tid']] = $item['name'];
    }
    return $terms;
  }

  /**
   * Get term names by term ids.
   *
   * @param array $ids
   *        Array of term ids.
   *
   * @return array
   *        Array of term names.
   *
   * @throws \atk4\dsql\Exception
   */
  public function getTermNamesByIds(array $ids)
  {
    $query = $this->dsql_connection->dsql();
    $results = $query
      ->field("name")
      ->table('terms')
      ->where('tid', 'IN', $ids)
      ->get();
    $termNames = [];
    foreach ($results as $result)
      $termNames[] = $result["name"];
    return $termNames;
  }
}