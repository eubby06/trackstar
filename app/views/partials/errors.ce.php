::if($session->has('errors'))
	<div class="alert">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	::$session->errors
	</div>
::endif

::if($session->has('success'))
	<div class="success">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	::$session->success
	</div>
::endif