<?php
defined( 'ABSPATH' ) OR exit;

function check_file_extension($file_extension) {
    
    //Permitted file types:
    $allowed_file_extensions = array(
        'json', 'wav', 'bin', 'gltf', 'png', 'jpg', 'jpeg', 'pdf'
    );

    $match = false;
    foreach ($allowed_file_extensions as $ext) {
        if ($file_extension === $ext) {
            $match = true;
        } 
    }
    return $match;
}

/*
 * Basic verification: check the file extensions of each of the files
 * in the uploaded zip, and check they match the allowed extensions.
 */
function verify_file($file_id) {
    
    $error = '';

    //Log any errors to debug.log
	$pluginlog = plugin_dir_path(__FILE__).'debug.log';
    //Get the file path for the ID    
    $file_location = get_attached_file($file_id);
    
    $zip = new ZipArchive();
    $res = $zip->open($file_location);
    //Iterate through the zip folder
    if ($res === true) {
        $num_files = $zip->numFiles;
        
        for( $i = 0; $i < $zip->numFiles; $i++ ){ 
            $stat = $zip->statIndex( $i ); 
            $file_name = basename( $stat['name'] );
            if (strpos($file_name, ".") == 0) {
                //this is a folder
                continue;
            }
            $file_extension = substr($file_name, strpos($file_name, ".") + 1);  
            $file_ext_valid = check_file_extension($file_extension);
            if (!$file_ext_valid) {
                $zip->close();
                error_log( "Unsupported file extension: ".$file_extension.PHP_EOL, 3, $pluginlog);
                $error = "an unsupported file extension: ".$file_extension;
                return $error;
            }
        }

        $zip->close();
    } else {
        error_log( "Could not unzip the folder. Error code: ".$res.PHP_EOL, 3, $pluginlog);
    }
    return $error;
}

add_filter('verify_arlem_file', 'verify_file', 10, 1);

?>