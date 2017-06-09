<?php
	$templates = 'features.twig';
	$context = Timber::get_context();
	$context['post'] = new TimberPost();
	$context['posts'] = Timber::get_posts();

	Timber::render($templates, $context);