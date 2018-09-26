<?php

global $user;

/**
 * Renders a system default template, which is essentially a PHP template.
 *
 * @param string $template_file
 *   Template file path.
 * @param array $variables
 *    A keyed array of variables that will appear in the output.
 *
 * @return string
 *   The output generated by the template.
 */
function gbooks_render_template($template_file, $variables)
{
  // Extract the variables to a local namespace
  extract($variables, EXTR_SKIP);

  // Start output buffering
  ob_start();

  // Include the template file
  include SITE_ROOT . '/' . $template_file;

  // End buffering and return its contents
  return ob_get_clean();
}

/**
 * Redirects to given path.
 *
 * @param string $path
 *    Path to redirect to.
 * @param int $http_code
 *    Http code.
 */
function redirect($path, $http_code = 302)
{
  header('Location: ' . $path, TRUE, $http_code);
  exit;
}

/**
 * Sets authentication messages accordingly.
 * @param string $message
 *    Current message.
 * @param string $type
 *    Message type corresponding to bootstrap class.
 */
function set_message($message, $type)
{
  if (!isset($_SESSION)) {
    session_start();
  }
  $_SESSION['messages'][$type][] = $message;
}

/**
 *Sets error messages accordingly.
 *
 * @param array $messages
 *    Current messages.
 */
function set_error_messages($messages)
{
  foreach ($messages as $message) {
    set_message($message, 'error');
  }
}

/**
 * Returns an array of messages.
 *
 * @return array array
 *    Array of messages to be returned
 */
function get_messages()
{
  if (!isset($_SESSION)) {
    session_start();
  }
  $messages = !empty($_SESSION['messages']) ? $_SESSION['messages'] : array();
  unset($_SESSION['messages']);
  return $messages;
}

/**
 * Renders messages displayed to the user.
 *
 * @param array $messages
 *    Messages to be displayed.
 * @return string
 *    HTML code for unordered list to display messages.
 */
function render_messages($messages)
{
  $output = '';
  if (!empty($messages)) {
    $classes = messages_bootstrap_classes();
    $output .= '<ul>';
    foreach ($messages as $type => $messages_list) {
      foreach ($messages_list as $message) {
        $output .= '<li class="' . (isset($classes[$type]) ? $classes[$type] : '') . '">' . $message . '</li>';
      }
    }
    $output .= '</ul>';
  }
  return $output;
}

function messages_bootstrap_classes()
{
  return array(
    'status' => 'alert alert-success',
    'error' => 'alert alert-warning',
  );
}

/**
 * Returns user for current session.
 *
 * @return UserEntity $user
 *    If session is set returns user, otherwise returns null.
 */
function get_session_user()
{
  global $user;
  if (!isset($_SESSION)) {
    session_start();
  }
  if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
  }
  return !empty($user) ? $user : NULL;
}

/**
 * Generates rating stars according to rating.
 *
 * @param float $rating
 *    Given rating.
 *
 * @return string
 *    String containing html code for generating rating stars.
 */
function gbooks_theme_generate_rating_stars($rating)
{
  $roundedRating = round($rating);
  $ratingStars = '';
  for ($i = 0; $i < 5; $i++) {
    if ($i < $roundedRating) {
      $ratingStars .= '<span class="glyphicon glyphicon-star"></span>';
    } else {
      $ratingStars .= '<span class="glyphicon glyphicon-star-empty"></span>';
    }
  }
  return $ratingStars;
}

function gbooks_theme_generate_select_options($items, $defaultValue = FALSE, $initialLabel = 'Any')
{
  $options = '';
  if (!empty($initialLabel)) {
    $options = '<option value="">' . $initialLabel . '</option>';
  }

  foreach ($items as $value => $label) {
    if ($defaultValue == $value) {
      $options .= '<option selected="selected" value="' . $value . '">' . $label . '</option>';
    } else {
      $options .= '<option value="' . $value . '">' . $label . '</option>';
    }
  }
  return $options;
}

/**
 * Displays books on homepage.
 *
 * @param array $books
 *    Array of books to be displayed.
 *
 * @return string
 *    HTML code for displaying the given books.
 */
function gbooks_generate_books($books)
{
  $homepageBooks = '';
  $i = 0;
  foreach ($books as $book) {
    if ($i === 0) {
      $homepageBooks .= '<div class="row">';
    }
    $i++;
    $rating = '';
    if (!empty($book->getRating())) {
      $rating = gbooks_theme_generate_rating_stars($book->getRating());
    }
    $homepageBooks .= '<div class="col-sm-3">
        <div class="text-center">
            <div class="image-wrapper">
                <img class="img-thumbnail" src="' . $book->getImage() . '">
            </div>
            <div class="book-title"><strong>' . $book->getTitle() . '</strong></div>
            <div>'
      . $rating . '</div>
        </div>
    </div>';
    if ($i === 4) {
      $homepageBooks .= '</div>';
      $i = 0;
    }
  }
  return $homepageBooks;
}

/**
 * Set session search fields.
 *
 * @param $array
 *    Array of search fields.
 */
function set_search_fields($array)
{
  if (!isset($_SESSION)) {
    session_start();
  }
  foreach ($array as $key => $value) {
    $_SESSION[$key] = $value;
  }
}

/**
 * Get session search fields.
 *
 * @return array
 *    Array of search fields.
 */
function get_search_fields()
{
  if (!isset($_SESSION)) {
    session_start();
  }
  $array = array('title' => isset($_SESSION['title']) ? $_SESSION['title'] : '',
    'author' => isset($_SESSION['author']) ? $_SESSION['author'] : '',
    'category' => isset($_SESSION['category']) ? $_SESSION['category'] : '',
    'priceFrom' => isset($_SESSION['priceFrom']) ? $_SESSION['priceFrom'] : '',
    'priceTo' => isset($_SESSION['priceTo']) ? $_SESSION['priceTo'] : '',
  );
  return $array;
}

/**
 * Unset session search fields.
 *
 * @param $array
 *    Array of search fields.
 */
function unset_search_fields($array)
{
  foreach ($array as $key => $value) {
    unset($_SESSION[$key]);
  }
}
