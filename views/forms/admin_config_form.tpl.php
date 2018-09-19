<div class="messages">
  <?php echo $message; ?>
</div>
<form method="post" id="admin-config-form" class="text-center" action="">
  <div class="row">
    <div class="col-lg-4"></div>
    <div class="form-group col-lg-4">
      <label for="google_api">Google Api Endpoint</label>
      <input type="text" class="form-control" id="google_api" name="google_api" value="<?php echo $gAPI; ?>">
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4"></div>
    <div class="form-group col-lg-4">
      <label for="max_books">Default Max books results per page</label>
      <input type="number" class="form-control" id="max_books" name="max_books" min="0" value="<?php echo $maxBook; ?>">
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
