<h1>Edit <?php echo $book->getTitle() ?> </h1>
<form method="post" id="book-edit-form">

  <h5>Title: <?php echo $book->getTitle() ?></h5>
  <h5><img src="<?php echo $book->getImage() ?>"/></h5>
  <h5>ISBN 10: <?php echo $book->getISBN10() ?></h5>
  <h5>ISBN 13: <?php echo $book->getISBN13() ?></h5>

  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description"><?php echo $book->getDescription() ?></textarea>
  </div>

  <button id="edit-submit" type="submit" class="btn btn-info btn-lg">SAVE</button>
</form>