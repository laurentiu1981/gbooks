<form id="admin-search-form" class="text-center" action="#">
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
  </div>
  <div class="form-group">
    <label for="author">Authors:</label>
    <select class="form-control" id="author" name="author">
      <option>Select Author</option>
    </select>
  </div>
  <div class="form-group">
    <label>Price</label>
    <input type="number" class="form-control" id="price-from" name="price-from" placeholder="from" min="0">
    <input type="number" class="form-control" id="price-to" name="price-to" placeholder="to" min="0">
  </div>
  <button type="submit" class="btn btn-primary btn-md center-block "><span class="glyphicon glyphicon-search"></span>Search
  </button>
</form>