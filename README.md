
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