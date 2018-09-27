<div class="col-sm-3">
  <a href="/book/<?php echo $book->getId() ?>">
    <div class="book-box text-center">
      <div class="image-wrapper">
        <img class="img-thumbnail" src="<?php echo $book->getImage() ?>">
      </div>
      <div class="book-title"><strong><?php echo $book->getTitle() ?></strong></div>
      <div>
        <?php echo $book->getStarsHtml() ?>
      </div>
    </div>
  </a>
</div>
