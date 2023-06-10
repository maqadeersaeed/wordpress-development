<?php

function simple_shot_code_wihout_attributes() {
	$output = '<img src ="https://static.djangoproject.com/img/logos/django-logo-negative.1d528e2cb5fb.png" />';
	return $output;
}

add_shortcode('simple_shot_code_wihout_attributes', 'simple_shot_code_wihout_attributes');


function simple_shortcode_with_attributes ($attr) {
	$array = shortcode_atts(array(
		'width' => '500',
		'height' => '400'
	), $attr);

	$image_src = 'https://static.djangoproject.com/img/logos/django-logo-negative.1d528e2cb5fb.png';
	$output = '<h1>Height</h1>'
				.'<img src="'.$image_src.'" alt="Girl in a jacket" width="'.$array['width'].'" height="'.$array['height'].'">';
	return $output;
}
add_shortcode('simple_shortcode_with_attributes', 'simple_shortcode_with_attributes');