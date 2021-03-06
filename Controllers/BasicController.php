<?php

namespace Controllers;

class BasicController
{

  public function __construct()
  {
    global $user;
    $this->title = '';
    $this->css = '';
    $this->content = '';
    $this->scriptElements = '';
    $this->messages = render_messages(get_messages());
    get_session_user();
    if ($user) {
      $this->userStateClass = 'user-logged-in';
    } else {
      $this->userStateClass = 'user-logged-out';
    }
    $this->addScript("/js/generic.js");
  }

  /**
   * Default action for any route.
   */
  public function get()
  {
    $this->content = 'Content for Basic Controller';
    $this->renderLayout('/views/layouts/basic.tpl.php');
  }

  /**
   * Render template with custom variables.
   *
   * @param string $template
   *   Template path.
   * @param array $vars
   *   Variables to be used by template.
   *
   * @return string
   *   Html output.
   */
  function render($template, $vars = array())
  {
    return gbooks_render_template($template, $vars);
  }


  /**
   * Export controller specific properties in array.
   *
   * This array will be passed to layout together with custom variables.
   * @see renderLayout().
   *
   * @return array
   *   Controller layout variables.
   */
  public function getLayoutVars()
  {
    return array(
      'title' => $this->title,
      'css' => $this->css,
      'content' => $this->content,
      'scriptElements' => $this->scriptElements,
      'userStateClass' => $this->userStateClass,
      'messages' => $this->messages,
    );
  }

  /**
   * Render output using a given template.
   *
   * @param string $layout
   *   Layout path.
   * @param array $customVars
   *   Variables to be used by layout.
   */
  function renderLayout($layout, $customVars = array())
  {
    $vars = $customVars + $this->getLayoutVars();
    echo $this->render($layout, $vars);
  }

  /**
   * Include script in layout.
   *
   * @param string $scriptFile
   */
  public function addScript($scriptFile)
  {
    $this->scriptElements .= "<script src='" . $scriptFile . "'></script>";
  }
}