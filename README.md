
# HOW TO USE MODEL

#### CREATING MODEL
```php
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';
}
```

#### INITIALIZE NEW MODEL
```php
$model = new User();
```

#### FIND ALL 
```php
$users = $model->findAll();
```

#### SORTING COLLECTION BY COLUMN
```php
$users = $users->sortBy('username');
```

#### ARRAY COLLECTION
```php
foreach($users as $user)
{
	echo $user->username . '<br />';
}
```

#### USING QUERY OBJECT
#### GET RECORDS
```php
$user = $q->select('*')
		->from('users')
		->whereBetween('username', 10, 20)
		->getAll();
```

#### GET SINGLE RECORD
```php
$user = $q->select('*')
		->from('users')
		->where('id', 2)
		->get();
```

#### INSERT RECORD
```php
$q->insert('users')
	->data(array(
		'username' => 'eubby',
		'password' => 'robs'
		))
	->execute();
```

#### UDPATE RECORD
```php
$q->update('users')
	->set(array(
		'username' => 'eubbynew'
		))
	->where('id','=',2)
	->execute();
```

#### DELETE RECORD
```php
$q->delete('users')
	->where('id','=',1)
	->execute();
```