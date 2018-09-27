<form action="/search" method="GET">
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Title"
           value="<?php echo isset($searchFields['title']) ? $searchFields['title'] : ''; ?>">
  </div>
  <div class="form-group">
    <label for="author">Authors:</label>
    <select multiple class="form-control chosen-select" id="author" name="author[]">
      <?php echo $options ?>
    </select>
  </div>
  <div class="form-group">
    <label for="category">Categories:</label>
    <select multiple class="form-control chosen-select" id="category" name="category[]">
      <?php echo $optionsCategories ?>
    </select>
  </div>
  <div class="form-group">
    <label>Price</label>
    <input type="number" class="form-control" id="price-from" name="price-from" placeholder="from" min="0"
           value="<?php echo isset($searchFields['price-from']) ? $searchFields['price-from'] : '';; ?>">
    <input type="number" class="form-control" id="price-to" name="price-to" placeholder="to" min="0"
           value="<?php echo isset($searchFields['price-to']) ? $searchFields['price-to'] : '';; ?>">
  </div>
  <button type="submit" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-search"></span>Search
  </button>
  <div class="messages"><?php echo $messages; ?></div>
</form>