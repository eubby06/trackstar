
## THIS FRAMEWORK IS UNDER DEVELOPMENT

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

### WORKING WITH MODEL RELATIONSHIPS

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
##### In this example, we do an inverse relationship between user and profile
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
##### How to query relationships
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
##### In this example, we define post model
```php
class Post extends \Core\Database\TSModelAbstract
{
	protected $table = 'posts';
}
```
##### How to query relationships
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
##### In this example, a user could have many roles or belongs to many groups and vice versa
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
##### In this example, we define role model and its relationship
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
##### How to query relationships
```php
$model = new User();

$user = $model->findById(1);

$roles = $user->roles;

$roles->each(function($role)
{
	echo $role->name;
});
```
##### Working with pivot table
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