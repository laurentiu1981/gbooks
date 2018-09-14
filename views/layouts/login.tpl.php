<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?> | GBooks</title>
	<meta http-equiv='Content-Type' content='text/html;charset=utf-8'/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="/css/style.css" rel="stylesheet" />
	<?php echo $css; ?>


</head>
<body>
<?php include SITE_ROOT . '/views/layouts/partials/header.tpl.php' ?>

<content class="col-lg-12" >
    <div><?php echo $content; ?></div>
    <div class="center-div">
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-4" for="username">Username</label>
                <div class="col-sm-5">
                    <input type='text' class="form-control" name="username" id="username" placeholder="username"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="password">Password</label>
                <div class="col-sm-5">
                    <input type='password' class="form-control" name="password" id="password" placeholder="password"/>
                </div>
            </div>
            <div class="from-group">
                <div class="col-sm-offset-4 col-sm-4">
                    <button type="submit" class="btn btn-default">Login</button>
                </div>
            </div>
        </form>
    </div>
</content>


<?php include SITE_ROOT . '/views/layouts/partials/footer.tpl.php' ?>
<?php echo $scriptElements; ?>
</body>
</html>