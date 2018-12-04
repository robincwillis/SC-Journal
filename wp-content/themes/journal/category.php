<?php
	$templates = 'travel.twig';
	$context = Timber::get_context();
	$context['post'] = new TimberPost();
	$context['posts'] = Timber::get_posts();
	$context['title'] = single_cat_title( '', false );

	Timber::render($templates, $context);