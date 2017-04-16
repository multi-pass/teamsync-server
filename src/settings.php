<?php
return array(
	'settings' => array(
		'displayErrorDetails' => TRUE, // set to false in production
		'addContentLengthHeader' => FALSE, // allow the web server to send the content-length header

		// Renderer settings
		'renderer' => array(
			'template_path' => (ROOT_DIR . '/public/'),
		)
	)
);
