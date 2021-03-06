
## THIS FRAMEWORK IS UNDER DEVELOPMENT

#### Contant Variables
```php
PATH_ROOT // root of your application
PATH_APP // path to your app directory
PATH_CORE // all core classes
PATH_VENDOR // path to third-party packages
PATH_VIEW // path to your views
PATH_CONFIG // path to config folder inside your app directory
```
#### Form Helper
```php
//basic form
	<div class="form">
		<?= FORM::open('contact', 'contact/send', array('class' => 'small-form')) ?>
		<ul>
			<li>		
		    	<?= FORM::label('Not Member?') ?>
				<?= FORM::checkbox('member', 'member', array('class' => 'member', 'id' => 'member'), $checked? ) ?>
			</li>
			<li>		
		    	<?= FORM::label('Payment Mode:') ?>
				<?= FORM::radio('mode', array('cash','credit','cheque'), array('class' => 'mode', 'id' => 'mode'), $default) ?>
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
```
#### HTML Helper
```php
//including your assets
<html>
<head>
	<title></title>
	<?= HTML::script('assets.js.main') ?>
	<?= HTML::style('assets.css.main') ?>
</head>
```
### HOW TO USE ColonEngine (a built-in templating engine)
#### Template Helpers
```php
//basic echoing
::$username // the same as <?php echo $username; ?>

//declaring variables
::country = 'Thailand' // the same as <?php $country = 'Thailand'; ?>
::$country // outputs 'Thailand'

// if statement
::if($address == 'uk')
	//...
::elseif($address == 'us')
	//...
::else
	//...
::endif

//loops
::foreach($users as $user) // outputs <?php foreach($users as $user) : ?>
::endforeach // ends foreach <?php endforeach; ?>

//setting master layout
::master('path.to.master.layout')

//specifying section containers
::yield('content')

//set up sections in partials
::section('content')
```
#### Creating Master Layout with :yield:
```php
<html>
<head>
	<title></title>
</head>
<body>
	<div class="top"> ::yield('content') </div>
	<div class="bottom"> ::yield('widget') </div>
</body>
</html>
```
#### Creating Partials with :section: and ::foreach
```php
::master('main')

::section('content')
	<h1>Content</h1>
	<table>
		<thead>
		<tr>
			<th>username</th>
			<th>password</th>
			<th>posts</th>
		</tr>
		</thead>
		<tbody>
		::foreach($users as $user)
		
		<tr>
			<td>::$user->username </td>
			<td>::$user->password </td>
			<td>

				::foreach($user->posts as $post)
				<p>::$post->title </p>
				::endforeach
			</td>
		</tr>

		::endforeach
		</tbody>
	</table>
::end

::section('widget')
	<h1>Sidebar Widget</h1>
	<ul>
	    <li>one</li>
	    <li>two</li>
	    <li>three</li>
	    <li>four</li>
	</ul>
::end
```
#### Handling errors and flash messages
```php
::if($session->has('errors'))
	<div class="errors">::$session->errors</div>
::endif

::if($session->has('success')) // check if success exists
	<div class="errors">::$session->success</div> // then access it directly
::endif
```

### HOW TO USE MODEL

#### Creating Class
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';
}
```

#### Initializing Model
```php
$model = new User();
```
#### Finding a Single Record
```php
$user = $model->findById($id);
```

#### Finding All Records
```php
$users = $model->findAll();
```

#### Sorting Collection By Column
```php
$users = $users->sortBy('username');
```

#### Filtering Collection By Callback
```php
$bannedUsers = $users->filter(function($user)
{
	return $user->isBanned();
});
```

#### Iterate Through a Collection Object
```php
$users->each(function($user)
{
	echo $user->username;
});
```
### HOW TO USE VALIDATOR IN YOUR MODEL

#### Creating Class
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';

	// adding rules
	public $rules = array(
		'username' 	=> 'required|min:2|unique:users',
		'password' 	=> 'required|numeric|max:8',
		'email'		=> 'email'
		);

	// sample attributes
	public $attributes = array(
		'username' 	=> 'johndoes',
		'password' 	=> '12334343',
		'email' 	=> 'admin@yahoo.com'
		);

	public function save()
	{
		// accessing validator object inside your model
		$this->validator->validate($this->attributes);

		if ($this->validator->passes())
		{
			return 'passes';
		}
		else
		{
			return $this->validator->errors();
		}
	}
}
```

### WORKING WITH RELATIONSHIPS

#### ONE TO ONE
##### In this example, a user could only have one profile
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';

	public function profile()
	{
		return $this->hasOne('Profile', 'user_id');
	}
}
```
##### Here we do an inverse relationship between user and profile
```php
class Profile extends \Core\Database\TSModelAbstract
{
	protected $table = 'profiles';

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}
}
```
##### How to query one-to-one relationship
```php
$model = new User();

$user = $model->findById(1);

$profile = $user->profile;

echo $profile->address;
```

#### ONE TO MANY
##### In this example, a user could have many posts
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';

	public function posts()
	{
		return $this->hasMany('Post', 'user_id');
	}
}
```
##### Here we define our post model
```php
class Post extends \Core\Database\TSModelAbstract
{
	protected $table = 'posts';
}
```
##### How to query one-to-many relationship
```php
$model = new User();

$user = $model->findById(1);

$posts = $user->posts;

$posts->each(function($post)
{
	echo $post->title;
});
```

#### MANY TO MANY
##### In this example, a user could have many roles and vice versa
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';

	public function roles()
	{
		return $this->belongsToMany('Role');
	}
}
```
##### Here we define our role model and its relationship
```php
class Role extends \Core\Database\TSModelAbstract
{
	protected $table = 'roles';

	public function users()
	{
		return $this->belongsToMany('User');
	}
}
```
##### How to query many-to-many relationship
```php
$model = new User();

$user = $model->findById(1);

$roles = $user->roles;

$roles->each(function($role)
{
	echo $role->name;
});
```
##### Working with pivot table of our many-to-many relationship
```php
$roles->each(function($role)
{
	$role->pivot->updated_at = $date->current();
	$role->pivot->save();
});
```

### HOW TO USE QUERY OBJECT

#### Initializing Query
```php
$q = new \Core\Database\TSSQLQuery();
```

#### Retrieving Records
```php
$users = $q->select('*')
		->from('users')
		->whereBetween('username', 10, 20)
		->getAll();
```

#### Retrieving Single Record
```php
$user = $q->select('*')
		->from('users')
		->where('id', 2)
		->get();
```

#### Inserting Record
```php
$q->insert('users')
	->data(array(
		'username' => 'eubby',
		'password' => 'robs'
		))
	->execute();
```

#### Updating Record
```php
$q->update('users')
	->set(array(
		'username' => 'eubbynew'
		))
	->where('id','=',2)
	->execute();
```

#### Deleting Record
```php
$q->delete('users')
	->where('id','=',1)
	->execute();
```