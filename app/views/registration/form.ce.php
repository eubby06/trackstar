::master('main')

::section('content')

    <?= FORM::open('registration', 'register', array('class' => 'form-signin')) ?>

	<?= HTML::h1('form-signin-heading', 'Please sign in') ?>

	<?= FORM::input('firstname', '', array('class' => 'input-block-level', 'placeholder' => 'First Name')) ?>
	<?= FORM::input('lastname', '', array('class' => 'input-block-level', 'placeholder' => 'Last Name')) ?>
	<?= FORM::input('username', '', array('class' => 'input-block-level', 'placeholder' => 'Username')) ?>
	<?= FORM::input('email', '', array('class' => 'input-block-level', 'placeholder' => 'Email address')) ?>
	<?= FORM::password('password', array('class' => 'input-block-level', 'placeholder' => 'Password')) ?>

    <?= FORM::submit('submit', 'Sign in', array('class' => 'btn btn-large btn-primary')) ?>
    
    <?= FORM::close() ?>

::end