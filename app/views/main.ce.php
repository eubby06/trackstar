<html>
<head>
	<title></title>
	<?= HTML::script('assets.js.main') ?>
	<?= HTML::style('assets.css.main') ?>
</head>
<body>

	<div class="content">::yield('content')</div>
	<?php $man = 'Yonanne'; ?>
	<h1>::$man</h1>
	<div class="form">
		<?= FORM::open('contact', '/view', array('class' => 'small-form')) ?>
		<ul>
			<li>		
		    	<?= FORM::label('Not Member?') ?>
				<?= FORM::checkbox('type', 'member', array('class' => 'member', 'id' => 'member'), true) ?>
			</li>
			<li>		
		    	<?= FORM::label('Membership Type:') ?>
				<?= FORM::radio('type', array('basic','advanced','super'), array('class' => 'member', 'id' => 'member'), 'basic') ?>
			</li>
		    <li>		
		    	<?= FORM::label('Username') ?>
				<?= FORM::input('username', 'John', array('class' => 'username', 'id' => 'user')) ?>
			</li>
		    <li>		
		    	<?= FORM::label('Password') ?>
				<?= FORM::password('password') ?>
			</li>
		    <li>		
		    	<?= FORM::label('Message') ?>
				<?= FORM::text('message') ?>
			</li>
			<li>
				<?= FORM::dropdown('countries', array('us' => 'USA', 'ph' => 'Philippines', 'th' => 'Thailand'), null, 'ph') ?>
			</li>
			<li><?= FORM::submit('Send') ?></li>
		</ul>
		<?= FORM::close() ?>
	</div>
</body>
</html>


