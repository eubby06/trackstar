::master('main')

::section('content')

	<h1>::Content</h1>
	<table>
		<thead>
		<tr>
			<th>username</th>
			<th>password</th>
			<th>posts</th>
		</tr>
		</thead>
		<tbody>
			::user = 'admin'
			::$user
		::foreach($users as $user)
		
		<tr>
			<td>::$user->username</td>
			<td>::$user->password</td>
			<td>

				::foreach($user->posts as $post)
				<p>::$post->title</p>
				::endforeach
			</td>
		</tr>

		::endforeach
		</tbody>
	</table>
::end
