<div class="messages">
  <?php echo $message; ?>
</div>
<form method="post" id="admin-config-form" action="">
  <div class="form-group">
    <label for="google_api">Google Api Endpoint</label>
    <input type="text" class="form-control" id="google_api" name="google_api" value="<?php echo $gAPI; ?>">
  </div>
  <div class="form-group">
    <label for="max_books">Default Max books results per page</label>
    <input type="number" class="form-control" id="max_books" name="max_books" min="0" value="<?php echo $maxBook; ?>">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
