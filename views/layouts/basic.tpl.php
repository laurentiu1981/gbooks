<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title; ?> | GBooks</title>
  <meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <?php echo $css; ?>


</head>
<body>
<?php include SITE_ROOT . '/views/layouts/partials/header.tpl.php' ?>

<content class="col-lg-12" >
  <div><?php echo $content; ?></div>
</content>

<?php include SITE_ROOT . '/views/layouts/partials/footer.tpl.php' ?>
</body>
<?php echo $scriptElements; ?>
</html>