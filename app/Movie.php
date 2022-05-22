<?php


namespace App;


use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Media\Video;

class Movie
{

    private string $pathIn = '';
    private string $pathOut = '';

    private Video $video;


    public function __construct(string $path)
    {
        $this->pathIn = $path;

        $ffmpeg = FFMpeg::create();
        $this->video = $ffmpeg->open($path);
    }

    public function cut(float $start, float $end): void
    {
        $this->video = $this->video->clip(TimeCode::fromSeconds($start), TimeCode::fromSeconds($end));
    }

    public function save(string $path): void
    {
        $this->pathOut = $path;
        $this->video->save(new \FFMpeg\Format\Video\X264(), $path);
    }


}