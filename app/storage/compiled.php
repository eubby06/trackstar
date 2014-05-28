<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <title>Go Shopping Online</title> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <meta name="description" content=""> <meta name="author" content=""> <!-- Le styles --> <?= HTML::style('vendor.bootstrap.css.bootstrap-min') ?> <?= HTML::style('vendor.bootstrap.css.bootstrap-responsive') ?> <?= HTML::style('assets.css.main') ?> <!-- HTML5 shim, for IE6-8 support of HTML5 elements --> <!--[if lt IE 9]> <script src="../assets/js/html5shiv.js"></script> <![endif]--> <!-- Fav and touch icons --> <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png"> <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png"> <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png"> <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png"> <link rel="shortcut icon" href="../assets/ico/favicon.png"> </head> <body> <div class="container"> <div class="masthead">
<h3 class="muted">Project name</h3>
<div class="navbar">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Services</a></li>
        <li><a href="#">Downloads</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    </div>
  </div>
</div><!-- /.navbar -->
</div> <?php if($session->has('errors')): ?>
	<div class="alert">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	<?php echo $session->errors; ?>
	</div>
<?php endif; ?>

<?php if($session->has('success')): ?>
	<div class="success">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	<?php echo $session->success; ?>
	</div>
<?php endif; ?>  <?= FORM::open('registration', 'register', array('class' => 'form-signin')) ?> <?= HTML::h1('form-signin-heading', 'Please sign in') ?> <?= FORM::input('firstname', '', array('class' => 'input-block-level', 'placeholder' => 'First Name')) ?> <?= FORM::input('lastname', '', array('class' => 'input-block-level', 'placeholder' => 'Last Name')) ?> <?= FORM::input('username', '', array('class' => 'input-block-level', 'placeholder' => 'Username')) ?> <?= FORM::input('email', '', array('class' => 'input-block-level', 'placeholder' => 'Email address')) ?> <?= FORM::password('password', array('class' => 'input-block-level', 'placeholder' => 'Password')) ?> <?= FORM::submit('submit', 'Sign in', array('class' => 'btn btn-large btn-primary')) ?> <?= FORM::close() ?>  <div class="footer"><p>&copy; Company 2013</p></div> </div> </body> </html> 