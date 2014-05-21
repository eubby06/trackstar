:master:('main')

:section:('content')
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
			<td>:c: $user->username :e:</td>
			<td>:c: $user->password :e:</td>
			<td>

				::foreach($user->posts as $post)
				<p>:c: $post->title :e:</p>
				::endforeach
			</td>
		</tr>

		::endforeach
		</tbody>
	</table>
:end:

:section:('widget')
	<h1>Sidebar Widget</h1>
	<ul>
	    <li>one</li>
	    <li>two</li>
	    <li>three</li>
	    <li>four</li>
	</ul>
:end: