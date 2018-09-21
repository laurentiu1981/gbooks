<div class="container">
  <div class="row">
    <div class="col-sm-2">
      <img src=<?php echo $book->getImage(); ?>>
    </div>
    <div class="col-sm-10">
      <h1><?php echo $book->getTitle(); ?></h1>
      <div class="row">
        <div class="col-sm-4">
          <strong>Authors:</strong> <?php echo $authors; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-4">
          <strong>Categories:</strong> <?php echo $categories; ?>
        </div>
        <div class="col-sm-offset-8 col-sm-1">
          <form action="https://www.google.com/">
            <button class="btn btn-primary">BUY</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container book-description">
  <div class="row">
    <div class="col-sm-12 ">
      <?php echo $book->getDescription(); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-2 book-rating">
      <strong>Rating:</strong> <?php echo $book->getRating(); ?>
      <div>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star"></span>
        <span class="glyphicon glyphicon-star-empty"></span>
      </div>
    </div>
  </div>
</div>
