<div class="container">
    <div class="row">
        <div class="col-sm-2">
            <img src="<?php echo $book->getImage() ?>">
        </div>
        <div class="col-sm-10">
            <h1><?php echo $book->getTitle(); ?></h1>
            <div class="row">
                <div class="col-sm-6">
                    <strong>Authors:</strong> <?php echo implode(', ', $book->getAuthors()); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <strong>Categories:</strong> <?php echo implode(', ', $book->getCategories()); ?>
                </div>
              <?php if ($book->getBuyLink()): ?>
                  <div class="col-sm-offset-8 col-sm-1">
                      <a href="<?php echo $book->getBuyLink() ?>" target="_blank" class="btn btn-info">BUY</a>
                  </div>
              <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="container book-description">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 ">
          <?php echo $book->getDescription(); ?>
        </div>
    </div>
  <?php if ($book->getRating()): ?>
    <div class="row">
        <div class="col-sm-offset-2 col-sm-2 book-rating">
            <div><strong>Rating: </strong><?php echo $book->getRating() ?>
                <div>
                  <?php echo $ratingStars; ?>
                </div>
            </div>
          <?php endif; ?>
        </div>