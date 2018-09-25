<form method="post" id="book-edit-form">
  <input name="id" value="<?php echo $book->getId() ?>" hidden/>
  <div class="form-group">
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $book->getTitle() ?>" readonly>
  </div>
  <div class="form-group">
    <label for="isbn_10">ISBN 10</label>
    <input type="text" class="form-control" id="isbn_10" name="isbn_10" value="<?php echo $book->getISBN10() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="isbn_13">ISBN 13</label>
    <input type="text" class="form-control" id="isbn_13" name="isbn_13" value="<?php echo $book->getISBN13() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" name="description"><?php echo $book->getDescription() ?></textarea>
  </div>
  <div class="form-group">
    <label for="price">Price</label>
    <input type="text" class="form-control" id="price" name="price" value="<?php echo $book->getPrice() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="currency">Currency</label>
    <input type="text" class="form-control" id="currency" name="currency" value="<?php echo $book->getCurrency() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="language">Language</label>
    <input type="text" class="form-control" id="language" name="language" value="<?php echo $book->getLanguage() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="buy-link">Buy Link</label>
    <input type="text" class="form-control" id="buy-link" name="buy-link" value="<?php echo $book->getBuyLink() ?>"
           readonly>
  </div>
  <div class="form-group">
    <label for="image">Image</label>
    <input type="text" class="form-control" id="image" name="image" value="<?php echo $book->getImage() ?>"
           readonly>
  </div>
  <input name="rating" value="<?php echo $book->getRating() ?>" hidden/>

  <button id="edit-submit" type="submit" class="btn btn-info btn-lg"><span class="glyphicon glyphicon-edit"> EDIT
  </button>
</form>