<?php
global $twig;
require_once './vendor/autoload.php';
$template_dir = './views/';

$vars = array(
  'globals' => array(
    'path' => '.',
  	'siteTitle' => 'Sailing Collective Journal',
  	'generalEmail' => 'info@thesailingcollective.com',
  	'phone' => '718 352 7989',
  	'streetAddress' => '123 Explorer Avenue',
  	'cityStateZip' => 'Work, New York 11201',
  	'instagramUrl' => 'http://instagram.com/',
		'facebookUrl' => 'http://facebook.com/',
		'twitterUrl' => 'http://twitter.com/',
		'pinterestUrl' => 'http://pinterest.com/'
  )
);

$loader = new Twig_Loader_Filesystem($template_dir);
$loader->addPath('./assets');

$twig = new Twig_Environment($loader, array(
    'cache' => false, //'/tmp/cache',
    'debug' => true
));