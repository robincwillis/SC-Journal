<?php
	$templates = 'photo-essays.twig';
	$context = Timber::get_context();
	$context['post'] = new TimberPost();
	$context['posts'] = Timber::get_posts();

	Timber::render($templates, $context);