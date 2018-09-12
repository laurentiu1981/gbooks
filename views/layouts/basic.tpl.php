<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title; ?> | GBooks</title>
  <meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php echo $css; ?>


</head>
<body>
<?php include SITE_ROOT . '/views/layouts/partials/header.tpl.php' ?>

<content>
  <div><?php echo $content; ?></div>
</content>

<?php include SITE_ROOT . '/views/layouts/partials/footer.tpl.php' ?>
</body>
<?php echo $scriptElements; ?>
</html>