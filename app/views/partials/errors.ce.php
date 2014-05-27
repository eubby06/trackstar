::if($session->has('errors'))
	<div class="errors">::$session->errors</div>
::endif

::if($session->has('success'))
	<div class="errors">::$session->success</div>
::endif