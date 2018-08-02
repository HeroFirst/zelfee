<?php

error_reporting(0); // Set E_ALL for debuging

// load composer autoload before load elFinder autoload If you need composer
//require './vendor/autoload.php';

// elFinder autoload
require 'php/autoload.php';


/**
 * Simple function to demonstrate how to control file access using "accessControl" callback.
 * This method will disable accessing files/folders starting from '.' (dot)
 *
 * @param  string  $attr  attribute name (read|write|locked|hidden)
 * @param  string  $path  file path relative to volume root directory started with directory separator
 * @return bool|null
 **/
function access($attr, $path, $data, $volume) {
	return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
		? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
		:  null;                                    // else elFinder decide it itself
}

function resizeAndCopy($maxWidth, $cmd, $result, $args, $elfinder, $volume) {
    $maxHeight = 300;
    $jpgQuality = 70;

    if ($maxWidth){
        if ($volume && $result && isset($result['added'])) {
            foreach($result['added'] as $item) {
                if ($file = $volume->file($item['hash'])) {
                    $path = $volume->getPath($item['hash']);
                    $pathOfCopy = dirname($path).'/.'.$maxWidth;
                    if (!file_exists($pathOfCopy)) mkdir($pathOfCopy, 0700);

                    if (strpos($file['mime'], 'image/') === 0 && ($srcImgInfo = @getimagesize($path))) {
                        $zoom = min(($maxWidth/$srcImgInfo[0]),($maxHeight/$srcImgInfo[1]));

                        $width_original = $srcImgInfo[0];
                        $height_original = $srcImgInfo[1];

                        if ($width_original > $maxWidth){
                            $width = round($srcImgInfo[0] * $zoom);
                            $height = round($srcImgInfo[1] * $zoom);
                            $tfp = tmpfile();
                            $info = stream_get_meta_data($tfp);
                            $temp = $info['uri'];
                            if ($src = fopen($path, 'rb')) {
                                stream_copy_to_stream($src, $tfp);
                                fclose($src);
                                if ($volume->imageUtil('resize', $temp, compact('width', 'height', 'jpgQuality'))) {
                                    @copy($temp, $pathOfCopy . '/' . $file['name']);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

function resize100($cmd, $result, $args, $elfinder, $volume) {
    resizeAndCopy(100, $cmd, $result, $args, $elfinder, $volume);
}

function resize250($cmd, $result, $args, $elfinder, $volume) {
    resizeAndCopy(250, $cmd, $result, $args, $elfinder, $volume);
}

function resize500($cmd, $result, $args, $elfinder, $volume) {
    resizeAndCopy(500, $cmd, $result, $args, $elfinder, $volume);
}

function resize1000($cmd, $result, $args, $elfinder, $volume) {
    resizeAndCopy(1000, $cmd, $result, $args, $elfinder, $volume);
}

function resize1600($cmd, $result, $args, $elfinder, $volume) {
    resizeAndCopy(1600, $cmd, $result, $args, $elfinder, $volume);
}


$opts = array(
	'roots' => array(
		array(
			'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
			'path'          => '../../uploads/images/source/',                 // path to files (REQUIRED)
			'URL'           => dirname($_SERVER['PHP_SELF']) . '/../../uploads/images/source/', // URL to files (REQUIRED)
			'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
            'imgLib'        => 'gd',
			'uploadAllow'   => array('image'),// Mimetype `image` and `text/plain` allowed to upload
			'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
			'accessControl' => 'access'                     // disable and hide dot starting files (OPTIONAL)
		)
	)
);

$connector = new elFinderConnector(new elFinder($opts));
$connector->run();

