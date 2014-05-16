<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<thead>
		<tr>
			<th>username</th>
			<th>password</th>
			<th>posts</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($users as $user) : ?>
		
		<tr>
			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->password; ?></td>
			<td>

				<?php foreach($user->posts as $post) : ?>
				<p><?php echo $post->title; ?></p>
				<?php endforeach; ?>
			</td>
		</tr>

		<?php endforeach; ?>
		</tbody>
	</table>
</body>
</html>