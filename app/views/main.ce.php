<?php

$html->start()
	->title('Trackstar Project')
	->body(function($div) {
		return $div->name('main')
					->render();
	})
	->render();