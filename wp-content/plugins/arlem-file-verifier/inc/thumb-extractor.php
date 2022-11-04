<?php
defined( 'ABSPATH' ) OR exit;

/*
 * Iterate through the ARLEM zip folder and look for a file that is named
 * "thumbnail.jpg"
 */
function is_thumbnail($file_id) {
    require_once(ABSPATH . 'wp-load.php');
    //Logging (saved in plugin folder)
	$pluginlog = plugin_dir_path(__FILE__).'debug.log';

    //Get the uploaded zip folder
    $zip_file_location = get_attached_file($file_id);
    $zip_file_name = basename($zip_file_location);
    
    //Open with ZipArchive and examine contents
    $zip = new ZipArchive();
    $res = $zip->open($zip_file_location);
    if ($res === true) {
        $num_files = $zip->numFiles;
        
        for( $i = 0; $i < $zip->numFiles; $i++ ){ 
            $stat = $zip->statIndex( $i ); 
            
            $file_name = basename( $stat['name'] );
            
            //NB this is case INsensitive
            if (strcasecmp($file_name, "thumbnail.jpg") == 0 || strcasecmp($file_name, "thumbnail.jpeg") == 0) {
                return true;
            }
        }
    }
    error_log("No thumbnail".PHP_EOL, 3, $pluginlog);
    return false;
}

/*
 * Iterate through the ARLEM zip folder, get the thumbnail, and set on the post
 */
function set_thumbnail($file_id, $post_id) {
    require_once(ABSPATH . 'wp-load.php');

    $attach_id = 0; //This will be the post ID of the created thumbnail attachment

    //Logging (saved in plugin folder)
	$pluginlog = plugin_dir_path(__FILE__).'debug.log';

    //Get the uploaded zip folder
    $zip_file_location = get_attached_file($file_id);
    $zip_file_name = basename($zip_file_location);
    
    //Open with ZipArchive and examine contents
    $zip = new ZipArchive();
    $res = $zip->open($zip_file_location);
    if ($res === true) {
        $num_files = $zip->numFiles;
        
        for( $i = 0; $i < $zip->numFiles; $i++ ){ 
            $stat = $zip->statIndex( $i ); 
            
            $file_name = basename( $stat['name'] );
            
            //NB this is case INsensitive
            if (strcasecmp($file_name, "thumbnail.jpg") == 0 || strcasecmp($file_name, "thumbnail.jpeg") == 0) {
                
                //Get the raw data
                $image_data = $zip->getFromIndex($i);
                
                //Create the location and file name 
                $upload_dir   = wp_upload_dir();
                $image_name = substr($zip_file_name, 0, strpos($zip_file_name, "."))."-thumb";
                $unique_file_name = wp_unique_filename($upload_dir['path'], $image_name);
                $filename = basename($unique_file_name);
                $file = $upload_dir['path'] . '/' . $filename . '.webp';
                
                //Save the data to the new location
                file_put_contents($file, $image_data);
                error_log("Saved file to ".$file.PHP_EOL, 3, $pluginlog);
                $wp_filetype = wp_check_filetype($filename, null);

                //Create the attachement in the WP database
                $attach_id = wp_insert_attachment( array(
                    'guid' => $upload_dir['url'] . '/' . $filename . '.webp',
                    'post_mime_type' => 'image/webp',
                    'post_title'     => sanitize_file_name($filename),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ), $file, $post_id );
                error_log("Upload ID is ".$attach_id.PHP_EOL, 3, $pluginlog);

                if (!is_wp_error($attach_id)) {
                    //If attachment post successfully created, create the metadata 
                    // and update
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    $attachment_meta_data = wp_generate_attachment_metadata( $attach_id, $file );
                    wp_update_attachment_metadata( $attach_id,  $attachment_meta_data );
                
                } else {
                    error_log("Failed to upload image: ".$attach_id.PHP_EOL, 3, $pluginlog);
                }
            }
        }

        error_log("Done!".PHP_EOL, 3, $pluginlog);
        $zip->close();
    } else {
        error_log( "Could not unzip. Error code: ".$zip.PHP_EOL, 3, $pluginlog);
    }

    //Return the post ID of the thumbnail, so it can be added to the post 
    // (does not happen in this method, required additional step)
    return $attach_id;
}

add_filter('check_arlem_thumbnail', 'is_thumbnail', 10, 1);
add_filter('set_arlem_thumbnail', 'set_thumbnail', 10, 2);

?>