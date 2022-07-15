<?php
/**
 * KB WIP The singe post part - arlem. 
 *
 * This is a content template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;
?>
<div class="post-arlem">
	<br>
	<h4>Files</h4>	
	<span class="arlem-link">

	<?php 
	$postid = get_the_ID();
	$download_link = get_field( 'arlem_upload', $postid ) ;
	$url = 	$download_link['url'];
	echo '<a class="download-arlem-link" href="'.esc_attr( $url ).'">Download Files</a>';
	echo '<span class="screen-reader-text">Download Files</span>';
	?>
	</span>
	<br>
	<div class="licence-info">
		<h4>Licence</h4>
	<?php 
		$licence_name = get_post_meta( $postid, 'licence_name', true );
		//Default URL
		$licence_url = 'https://creativecommons.org/about/cclicenses/';
		$licence_sn = '';
		
		while( have_rows('licences', 'option') ) : the_row();
			$lic = get_sub_field('licence_name');
			if ( $lic == $licence_name ) {
				$licence_url = get_sub_field('licence_url');
				$licence_sn = get_sub_field('licence_short_name');
			}
		endwhile;
		if (empty( $licence_name ) || ! $licence_name) {
			echo '<p><i>A licence has not been set</i></p>';
			echo '<span class="screen-reader-text">A licence has not been set</span>';
		} else {
			echo '<p><i>Licenced under <a href="'.$licence_url.'">'.$licence_name.' ('.$licence_sn.')</a></i></p>';
			echo '<span class="screen-reader-text">Licenced under '.$licence_name.' ('.$licence_sn.')</span>';
		}
	?>
	</div>
</div>	

