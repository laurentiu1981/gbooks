<form action="#">
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Title"
           value="<?php echo $searchFields['title']; ?>">
  </div>
  <div class="form-group">
    <label for="author">Authors:</label>
    <select class="form-control chosen-select" id="author" name="author">
      <?php echo $options ?>
    </select>
  </div>
  <div class="form-group">
    <label for="category">Categories:</label>
    <select class="form-control chosen-select" id="category" name="category">
      <?php echo $optionsCategories ?>
    </select>
  </div>
  <div class="form-group">
    <label>Price</label>
    <input type="number" class="form-control" id="price-from" name="price-from" placeholder="from" min="0"
           value="<?php echo $searchFields['priceFrom']; ?>">
    <input type="number" class="form-control" id="price-to" name="price-to" placeholder="to" min="0"
           value="<?php echo $searchFields['priceTo']; ?>">
  </div>
  <button type="submit" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-search"></span>Search
  </button>
  <div class="messages"><?php echo $messages; ?></div>
</form>