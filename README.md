
*** HOW TO USE MODEL ***

// CREATING MODEL
class User extends \Core\Database\TSModelAbstract
{
	protected $table = 'users';
}

// INITIALIZE NEW MODEL
$model = new User();

// FIND ALL 
$users = $model->findAll();

// SORTING COLLECTION BY COLUMN
$users = $users->sortBy('username');

// ARRAY COLLECTION
foreach($users as $user)
{
	echo $user->username . '<br />';
}

// USING QUERY OBJECT
// GET RECORDS
$user = $q->select('*')
		->from('users')
		->whereBetween('username', 10, 20)
		->getAll();

// GET SINGLE RECORD
$user = $q->select('*')
		->from('users')
		->where('id', 2)
		->get();

// INSERT RECORD
$q->insert('users')
	->data(array(
		'username' => 'eubby',
		'password' => 'robs'
		))
	->execute();

// UDPATE RECORD
$q->update('users')
	->set(array(
		'username' => 'eubbynew'
		))
	->where('id','=',2)
	->execute();

// DELETE RECORD
$q->delete('users')
	->where('id','=',1)
	->execute();
