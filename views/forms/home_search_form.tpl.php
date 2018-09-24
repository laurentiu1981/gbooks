<form action="#">
    <span>
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Title">
    </span>
    <span>
        <label for="author">Authors:</label>
        <select class="form-control chosen-select" id="author" name="author">
            <?php echo $options ?>
        </select>
    </span>
    <span>
        <label for="category">Categories:</label>
        <select class="form-control chosen-select" id="category" name="category">
            <?php echo $optionsCategories ?>
        </select>
    </span>
    <span>
        <label>Price</label>
        <input type="number" class="form-control" id="price-from" name="price-from" placeholder="from" min="0">
        <input type="number" class="form-control" id="price-to" name="price-to" placeholder="to" min="0">
    </span>
    <button type="submit" class="btn btn-primary btn-md center-block "><span class="glyphicon glyphicon-search"></span>Search
    </button>
</form>