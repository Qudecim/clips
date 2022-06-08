<?php

require '../vendor/autoload.php';

define("MOVIES_DIR","D:/clips_new/movies/");
define("SUBS_DIR","D:/clips_new/subs/");
define("OUT_DIR","D:/clips_new/out/");

$o = new App\Commands\Main();
$o->start();

//$ffmpeg = FFMpeg\FFMpeg::create();
//$video = $ffmpeg->open('../storage/movie/1.mp4');
////$video
////    ->filters()
////    ->resize(new FFMpeg\Coordinate\Dimension(320, 240))
////    ->synchronize();
//$video
//    ->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10))
//    ->save('frame.jpg');
//$video
//    ->save(new FFMpeg\Format\Video\X264(), 'export-x264.mp4')
//    ->save(new FFMpeg\Format\Video\WMV(), 'export-wmv.wmv')
//    ->save(new FFMpeg\Format\Video\WebM(), 'export-webm.webm');