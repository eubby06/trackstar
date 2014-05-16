:master:('main')

:section:('content')
	<table>
		<thead>
		<tr>
			<th>username</th>
			<th>password</th>
			<th>posts</th>
		</tr>
		</thead>
		<tbody>
		:c: foreach($users as $user) :e:
		
		<tr>
			<td>:c: echo $user->username :e:</td>
			<td>:c: echo $user->password :e:</td>
			<td>

				:c: foreach($user->posts as $post) :e:
				<p>:c: echo $post->title :e:</p>
				:c: endforeach :e:
			</td>
		</tr>

		:c: endforeach :e:
		</tbody>
	</table>
:end:
