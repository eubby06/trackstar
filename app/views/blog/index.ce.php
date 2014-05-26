::master('main')

::section('content')

	::man = 'Registration Form'
	<h1>::$man</h1>
	<div class="form">
		<?= FORM::open('contact', '/store', array('class' => 'small-form')) ?>
		<ul>
		    <li>		
		    	<?= FORM::label('Username') ?>
				<?= FORM::input('username', '', array('class' => 'username', 'id' => 'user')) ?>
			</li>
		    <li>		
		    	<?= FORM::label('Password') ?>
				<?= FORM::password('password') ?>
			</li>
			<li><?= FORM::submit('Send') ?></li>
		</ul>
		<?= FORM::close() ?>
	</div>

::end
