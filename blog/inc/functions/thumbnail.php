<?php
// 自动缩略图
function ygj_thumbnail($sltw, $slth) {
    global $post;
    if ( get_post_meta($post->ID, 'wzshow', true) ) {
    	$image = get_post_meta($post->ID, 'wzshow', true);
		echo '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/timthumb.php?src='.$image.'&w='.$sltw.'&h='.$slth.'&zc=1" alt="'.$post->post_title .'" /></a>';
    } else {
	        $content = $post->post_content;
	        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?\/>/sim', $content, $strResult, PREG_PATTERN_ORDER);
	        $n = count($strResult[1]);
	        if($n > 0){
				echo '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/timthumb.php?src='.$strResult[1][0].'&w='.$sltw.'&h='.$slth.'&zc=1" alt="'.$post->post_title .'" /></a>';
	        } else { 
				$random = mt_rand(1, 10);
				echo '<a href="'.get_permalink().'"><img src="'.get_template_directory_uri().'/images/random/r'. $random .'.png" alt="'.$post->post_title .'" /></a>';
	        }
	}
}
// 自动缩略图
function ygj_thumbnaillink() {
    global $post;
    if ( get_post_meta($post->ID, 'wzshow', true) ) {
    	$imagess = get_post_meta($post->ID, 'wzshow', true);
    } else {
	        $content = $post->post_content;
	        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?\/>/sim', $content, $strResult, PREG_PATTERN_ORDER);
	        $n = count($strResult[1]);
	        if($n > 0){
				$imagess = $strResult[1][0];
	        } else { 
				$random = mt_rand(1, 10);
				$imagess = get_template_directory_uri().'/images/random/r'. $random .'.png';
	        }
	}
	return $imagess;
}