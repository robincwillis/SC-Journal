<?php
include ('./controller.php');
$template = basename(__FILE__,'.php').'.twig';

echo $twig->render($template, $vars );
?>