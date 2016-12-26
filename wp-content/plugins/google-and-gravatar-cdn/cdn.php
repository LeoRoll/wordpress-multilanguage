<?php
/*
	Plugin Name:谷歌服务与Gravatar头像加速
	Description:本插件可针对面对Google前端库、Google字体库和Gravatar头像进行替换加速，CDN为360与多说加速器。
	Version: 1.0
	Author: JaQuan
	Author URI: https://github.com/springjk
*/

/**
 * Use Qihoo 360 Open Ajax Libs Service to replace Google's.
 *
 * @param String $text
 * @return String
 */
function cdn_google_ajax_libs($text)
{
	$pos = strpos($text, 'googleapis.com');

	if ($pos !== false) {
		return '';
	}

	return $text;
  // return str_replace('//ajax.googleapis.com/', '//ajax.useso.com/', $text);
}

// /**
//  * Use Qihoo 360 Open Fonts Service to replace Google's.
//  *
//  * @param String $text
//  * @return String
//  */
// function cdn_google_fonts($text)
// {
// 	if ($pos !== false) {
// 		return '';
// 	}

// 	return $text;
//   // return str_replace('https://fonts.googleapis.com/', 'http://fonts.useso.com/', $text);
// }

/**
 * Use DuoShuo Open Gravatar Service to replace Gravatar's.
 *
 * @param String $text
 * @return String
 */
function cdn_avatar($avatar)
{
	$official = array(
		'0.gravatar.com',
		'1.gravatar.com',
		'2.gravatar.com',
		'www.gravatar.com',
		'secure.gravatar.com'
	);

  return str_replace($official, 'gravatar.duoshuo.com', $avatar);
}

add_filter('style_loader_tag', 'cdn_google_ajax_libs');

// add_filter('style_loader_tag', 'cdn_google_fonts');

add_filter('get_avatar', 'cdn_avatar');
