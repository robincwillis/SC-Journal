<?php
	$templates = 'travel.twig';
	$context = Timber::get_context();
	$context['post'] = new TimberPost();
	$context['posts'] = Timber::get_posts();
	$context['title'] = single_cat_title( '', false );
	$term_id = get_queried_object()->term_id;

	$more = array(
    'orderby'           => 'RAND', 
    'order'             => 'ASC',
    'hide_empty'        => true, 
    'exclude'           => array(1, $term_id),
    'exclude_tree'      => array(), 
    'include'           => array(),
    'fields'            => 'all', 
    'hierarchical'      => true, 
    'child_of'          => 0,
    'childless'         => false,
    'pad_counts'        => false,  
    'cache_domain'      => 'core'
  );

	$context['side_links'] = Timber::get_terms('category', $more);

// echo '<pre>';
// var_dump( Timber::get_terms('category', $more) );
// echo '</pre>';

	Timber::render($templates, $context);