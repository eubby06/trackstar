
# THIS IS FRAMEWORK IS UNDER DEVELOPMENT!

## HOW TO USE MODEL

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

#### Finding All Records
```php
$users = $model->findAll();
```

#### Sorting Collection By Column
```php
$users = $users->sortBy('username');
```

#### Array Collection Object
```php
foreach($users as $user)
{
	echo $user->username . '<br />';
}
```


## HOW TO USE QUERY OBJECT
#### Retrieving Records
```php
$user = $q->select('*')
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