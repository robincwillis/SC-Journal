<?php
	$templates = 'article.twig';
	$context = Timber::get_context();
	$context['post'] = new TimberPost();
	$related_query = array(
	  'orderby' => 'rand', 
	  'cat' => get_the_category()[0]->cat_ID, 
	  'posts_per_page' => 6,
	  'post__not_in' => array($post->ID)
	);
	
	$context['related'] = Timber::get_posts($related_query);

	Timber::render($templates, $context);