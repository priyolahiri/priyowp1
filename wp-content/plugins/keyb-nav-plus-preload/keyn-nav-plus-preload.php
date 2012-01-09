<?php
/*
Plugin Name: PriyoLahiri Keyboard Nav and Preload
Plugin URI: http://www.priyolahiri.co.cc
Description: Previous-Next scroll of blog post/posts with the Pageup/Leftarrow and Pagedown/Rightarrow keys and preloading of next/prev content
Version: 1.0
Author: priyolahiri
*/
//require_once('FirePHPCore/FirePHP.class.php');
//require_once('FirePHPCore/fb.php');
add_action('wp_footer','keyboard_shortcut_navigation');
add_action('wp_head', 'preload');

function preload() {
	if (is_single()) {
		global $id;
		$prev_link = get_permalink(get_adjacent_post(true, '', true));
		$next_link = get_permalink(get_adjacent_post(true, '', false));
		$curr_link = get_permalink(get_post($id));
		if ($prev_link != $curr_link && $prev_link != "") {
			echo '<link rel="prerender" href="'.$prev_link.'" />
			<link rel="preload" href="'.$prev_link.'" />
			';		
		}
		if ($next_link != $curr_link && $next_link != "") {
			echo '<link rel="prerender" href="'.$next_link.'" />
			<link rel="preload" href="'.$next_link.'" />
			';
		}
	}
}

function keyboard_shortcut_navigation(){
	global $paged, $wp_query;
	if ( !$max_page )
		$max_page = $wp_query->max_num_pages;
	if ( !$paged )
		$paged = 1;
	$nextpage = intval($paged) + 1;
?>
<?php if( is_single() ) : ?>
<script type="text/javascript">
    document.onkeydown = chang_page;
    function chang_page(e) {
    var e = e || event,
    keycode = e.which || e.keyCode;
	var obj = e.target || e.srcElement;
	if(obj.tagName.toLowerCase()=="textarea"){return;}
	if(obj.tagName.toLowerCase()=="input"){return;}
<?php
global $id;
$prev_link = get_permalink(get_adjacent_post(true, '', true));
$next_link = get_permalink(get_adjacent_post(true, '', false));
$curr_link = get_permalink(get_post($id));
if ($prev_link != $curr_link && $prev_link != "") {
	echo "if (keycode == 33 || keycode == 37) location = '$prev_link'; ";
}
if ($next_link != $curr_link && $next_link != "") {
	echo "if (keycode == 34 || keycode == 39) location = '$next_link'; ";
}
?>    
    
    }
</script>
<?php elseif( is_home() || is_category() ) : ?>
<script type="text/javascript">
    document.onkeydown = chang_page;function chang_page(e) {
		var e = e || event,
		keycode = e.which || e.keyCode;
		var obj = e.target || e.srcElement;
		if(obj.tagName.toLowerCase()=="textarea"){return;}
		if(obj.tagName.toLowerCase()=="input"){return;}
		if (keycode == 33 || keycode == 37) location = '<?php echo get_previous_posts_page_link(); ?>';
		if (keycode == 34 || keycode == 39) 
		<?php if ( $nextpage <= $max_page ) : ?>
			location = '<?php echo get_next_posts_page_link(); ?>';
		<?php else : ?>
			location = '<?php echo get_pagenum_link( $max_page ); ?>';	
		<?php endif; ?>
    }
</script>
<?php endif; ?>
<?php
}
?>