<?php
namespace SIM\HEICTOJPEG;
use SIM;

add_filter('sim-library-accepted-files', __NAMESPACE__.'\addAcceptedFiles');
function addAcceptedFiles($files){
    return $files.', image/heic, image/heif';
}