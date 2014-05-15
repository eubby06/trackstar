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
		</tr>
		</thead>
		<tbody>

		<?php foreach($users as $user) : ?>
		
		<tr>
			<td><?php echo $user->username; ?></td>
			<td><?php echo $user->password; ?></td>
		</tr>

		<?php endforeach; ?>

		</tbody>
	</table>
</body>
</html>