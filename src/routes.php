<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
	// Render index view
	return $this->renderer->render($response, 'index.html', $args);
});
