<html> <head> <title></title> <?= HTML::script('assets.js.main') ?> <?= HTML::style('assets.css.main') ?> </head> <body> <h1>header</h1> <?php if($session->has('errors')): ?> <div class="errors"><?php echo $session->errors; ?></div> <?php endif; ?> <?php if($session->has('success')): ?> <div class="errors"><?php echo $session->success; ?></div> <?php endif; ?> <div class="content"> <h1>Registration Form</h1> <div class="form"> <?= FORM::open('contact', '/register', array('class' => 'small-form')) ?> <ul> <li> <?= FORM::label('Username') ?> <?= FORM::input('username', '', array('class' => 'username', 'id' => 'user')) ?> </li> <li> <?= FORM::label('Password') ?> <?= FORM::password('password') ?> </li> <li><?= FORM::submit('Send') ?></li> </ul> <?= FORM::close() ?> </div> </div> <div>footer</div> </body> </html> 