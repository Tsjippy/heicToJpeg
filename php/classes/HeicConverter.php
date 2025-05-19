<?php
namespace SIM\HEICTOJPEG;
use SIM;

class HeicConverter{
    public function __construct(){
        $path   = MODULE_PATH  . 'lib/vendor/maestroerror/php-heic-to-jpg/bin/heicToJpg';
        if(!is_executable($path)){
            chmod($path, 0555);
        }
    }

    /**
     * Converts heic images to jpg. Stores the jpg to a file for future use as the conversion is quite slow
     *
     * @param   string  $path       The path or url to the file
     * @param   string  $dest       The path to the destination file. If left empty it will echo the image to the screen
     *
     * @return  boolean|string      Whether the conversion was succesfull or if destination is empty the image blob(url)
     */
    public function convert($path, $dest=''){
        $path   = SIM\urlToPath($path);

        if(!is_file($path) || !\Maestroerror\HeicToJpg::isHeic($path)) {
            return false;
        }

        // We should print it to the screen
        if(empty($dest)){
            $ext        = pathinfo($path, PATHINFO_EXTENSION);
            $checkPath  = str_replace(".$ext", '.jpeg', $path);

            if(file_exists($checkPath)){
                // Get existing file data
                $jpg = file_get_contents($checkPath);
            }else{
                // convert to jpeg
                $jpg    = \Maestroerror\HeicToJpg::convert($path)->get();

                $size   = getimagesizefromstring($jpg);

                // reduce size, as we do not need super big images
                if($size[0] > 1024 || $size[1] > 1024){
                    //store the jpeg so that we dont have to reduce again next time
                    $img        = imagecreatefromstring($jpg);
                    $imgResized = imagescale($img , 1024);

                    // Store the file
                    imagejpeg ($imgResized, $checkPath);
                    
                    $jpg = file_get_contents($checkPath);
                }else{
                    // store as file
                    imagejpeg ($jpg, $checkPath);
                }
            }

            $base64 = base64_encode($jpg);

            return "data:image/jpeg;base64, $base64";
        }else{
            try{
                return \Maestroerror\HeicToJpg::convert($path)->saveAs($dest);
            }catch (\Exception $e) {
                SIM\printArray($e, true);
                return explode(':', $e->getMessage())[0];
            }
        }
    }
}
