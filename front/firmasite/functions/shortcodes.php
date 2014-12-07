<?php

// http://wordpress.org/support/topic/how-to-make-use-of-the-post-format-link
// Extract first occurance of text from a string
if( !function_exists ('firmasite_extract_from_string') ) :
function firmasite_extract_from_string($start, $end, $tring) {
	$tring = stristr($tring, $start);
	$trimmed = stristr($tring, $end);
	return substr($tring, strlen($start), -strlen($trimmed));
}
endif;


// its not loading on every post but you can call it if you want
add_filter('the_content', 'firmasite_replace_image_links',5);
function firmasite_replace_image_links($content){
	global $firmasite_settings, $post, $total_images_out;
	
	if ("image" != get_post_format()) return $content;
	
		$caption_shortcode = firmasite_extract_from_string('[caption', ']', $content);	
		if($caption_shortcode) {
			return $content;
		}

		$gallery_shortcode = firmasite_extract_from_string('[gallery', ']', $content);	
		if(!$gallery_shortcode) {
			if(is_single())
				$content = "[gallery]".$content;
		}

		// clearing inserted attachments
		$content = preg_replace("/<a[^>]+\><img[^>]+\><\/a>/", "", $content);


	 return $content;
}


add_filter('the_content', 'firmasite_replace_gallery_links',5);
function firmasite_replace_gallery_links($content){
	global $firmasite_settings, $post;
	
	if ("gallery" != get_post_format()) return $content;
	
		$gallery_shortcode = firmasite_extract_from_string('[gallery', ']', $content);	
		if(!$gallery_shortcode) {
			if(is_single())
				$content = "[gallery]".$content;
		}

		// clearing inserted attachments
		$content = preg_replace("/<a[^>]+\><img[^>]+\><\/a>/", "", $content);


	 return $content;
}


function firmasite_gallery_count($post_id,$classes = "", $gallery_count = "") {
	
	if (!isset($gallery_count) || empty($gallery_count)) {
	// Check if its file link in our own wordpress upload
		$gallery_uploads = new WP_Query( array(
			'post_parent' => $post_id,
			'post_status' => 'inherit',
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'order' => 'ASC',
			'orderby' => 'menu_order ID',
			'posts_per_page' => -1,
			'update_post_term_cache' => false,
		) );
		if ($gallery_uploads->posts) {
			/* foreach ($gallery_uploads->posts as $gallery_upload) {} */		
			$total_images = count( $gallery_uploads->posts );
		}
	} else {
		$total_images = $gallery_count;
	}

	$total_images_out = "";
	if(isset($total_images)) {
		$total_images_out = sprintf( _n( 'This gallery contains %1$s photo.', 'This gallery contains %1$s photos.', $total_images, 'firmasite' ),								
								number_format_i18n( $total_images )
							); 		
		$total_images_out  = '<span class="gallery-count '.$classes.'"><i class="icon-picture"></i> ' . $total_images_out . '</span> ';
	
	}
	
	return $total_images_out;

}


add_filter( 'post_gallery', 'firmasite_post_gallery', 10, 2 );
function firmasite_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;
	
	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	$attr = apply_filters("firmasite_gallery_attr", $attr);
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'h4',
		'columns'    => 3,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => '',
		'link'  	 => 'none'
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
/*	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';
*/
	$selector = "gallery-{$post->ID}-{$instance}";
	$total_images = count( $attachments );

$output = "<div id='$selector' class='carousel slide' data-rel='carousel'>";
  if ($total_images > 1) {
	  $i = 0;
	  $gallery_slide_active = " active";
	  $output .= '<ol class="carousel-indicators">';
		foreach ( $attachments as $id => $attachment ) {
			$output .= "<li data-target='#$selector' data-slide-to='$i' class='$gallery_slide_active'></li>";
			$i++;
			$gallery_slide_active = ""; // only first item
		}
	  $output .= '</ol>';
  }

  $output .= '<div class="carousel-inner">';


	$i = 0;
	$gallery_slide_active = " active";
	foreach ( $attachments as $id => $attachment ) {
		//$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		if(!isset($attr['link'])) $attr['link'] = "post";
			switch($attr['link']){
				case 'file':
					$link =	wp_get_attachment_link($id, $size, false, false);
					break;				
				case 'none':
					$link =	wp_get_attachment_image($id, $size);
					break;				
				default:	
				case 'post':
					$link =	wp_get_attachment_link($id, $size, true, false);
					break;
			}
		

		$output .= "<div class='thumbnail item $gallery_slide_active'>";
		$gallery_slide_active = ""; // only first item
		 //$output .= " <img src='assets/img/bootstrap-mdo-sfmoma-01.jpg' alt=''>";
		   $output .= $link;
			  //$output .= "<h4>First thumbnail label</h4>";	
				if ( $captiontag && (trim($attachment->post_excerpt) || trim($attachment->post_title)) ) {
				  $output .= "<div class='carousel-caption'>";
					if (trim($attachment->post_title))
					$output .= "
						<{$captiontag} class='wp-title-text gallery-title'>
						" . wptexturize($attachment->post_title) . "
						</{$captiontag}>";
					if (trim($attachment->post_excerpt))
					$output .= "						
						<p class='wp-caption-text gallery-caption'>
						" . wptexturize($attachment->post_excerpt) . "
						</p>";
						
			     $output .= "</div>";
				}
		$output .= "</div>";

	}


  $output .= "</div>";
  $output .= "<!-- Carousel nav -->";
if ($total_images > 1){
  $output .= "<a class='carousel-control left' href='#$selector' data-slide='prev'><span class='icon-prev'></span></a>";
 $output .=  "<a class='carousel-control right' href='#$selector' data-slide='next'><span class='icon-next'></span></a>";
}
$output .= "</div>";
if ($total_images > 1)
$output .= firmasite_gallery_count($post->ID,"label label-success",$total_images);
$output .= "<hr />\n";
	
    return $output;
}
