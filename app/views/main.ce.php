<html>
<head>
	<title></title>
	<?= HTML::script('assets.js.main') ?>
	<?= HTML::style('assets.css.main') ?>
</head>
<body>
	::include('partials.header')

	::if($session->has('errors'))
		<div class="errors">::$session->errors</div>
	::endif

	::if($session->has('success'))
		<div class="errors">::$session->success</div>
	::endif

	<div class="content">::yield('content')</div>

	::include('partials.footer')

</body>
</html>


