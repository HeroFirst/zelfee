<?php
/**
 * Created by PhpStorm.
 * User: serg
 * Date: 18.11.2016
 * Time: 4:43
 */

namespace Zelfi\Modules\Upload;


use Eventviva\ImageResize;
use Zelfi\Utils\AppUtils;
use EscapeWork\Resize\Resize;

class Upload
{

    /**
     * @param $id
     * @param $name
     * @return bool
     */
    public static function uploadUserCover($id, $name){
        $dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/system/users/avatars/'.$id;
        $dir_url = '/uploads/system/users/avatars/'.$id;

        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $cover = $_FILES[$name];

        if (!empty($cover)){
            $name = $cover["name"];
            $type = $cover["type"];
            $size = $cover["size"];
            $tmpName = $cover["tmp_name"];

            if ($cover["error"] !== UPLOAD_ERR_OK) {
                echo 'error on upload = '.$cover["error"];
                exit;
            }

            $name_original = md5($id.date('ddmmyyyy')).AppUtils::fileExt($type);

            $items = glob($dir.'/*');
            foreach($items as $item){
                if(is_file($item))
                    unlink($item);
            }

            $success = move_uploaded_file($tmpName,
                $dir . '/' . $name_original);
            if (!$success) {
                echo "<p>Unable to save file.</p>";
            } else {
                return self::resize($dir, $dir_url, $name_original);
            }
        }

        return false;
    }

    private static function resize($dir, $dir_url, $image){

        $sizes = array(
            'small' => array(
                'width'  => 100
            ),
            'normal' => array(
                'width'  => 250,
            ),
            'big' => array(
                'width'  => 500
            )
        );

        $files['original'] = $dir_url.'/'.$image;

        foreach ($sizes as $prefix => $size) {
            try {
                $newImg = $dir . '/'. $prefix . '-' .$image;

                $upload = new \EscapeWork\Resize\Upload(
                    $dir . '/'. $image,
                    $newImg
                );

                $resize = new Resize($newImg);
                $resize->setWidth($size['width'])->resize();

                $files[$prefix] = $dir_url. '/'. $prefix . '-' . $image;
            }
            catch(UploadException $e) {

            }
            catch (ResizeException $e) {

            }
        }

        return $files;

    }

}