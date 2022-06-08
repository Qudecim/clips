<?php


namespace App;


use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Media\Video;

class Movie
{

    private string $pathIn = '';
    private string $pathOut = '';

    private float $timeOffsetL = 0.5;
    private float $timeOffsetR = 0.5;
    private string $boxColor = 'color=#333333@0.6';

    private Video $video;


    public function __construct(string $path)
    {
        $this->pathIn = MOVIES_DIR . $path;

        $ffmpeg = FFMpeg::create();
        $this->video = $ffmpeg->open($this->pathIn);
    }

    public function cut(float $start, float $end): void
    {
        $this->video = $this->video->clip(TimeCode::fromSeconds($start - $this->timeOffsetL), TimeCode::fromSeconds($end + $this->timeOffsetR));
    }

    public function drawText(string $text): void
    {
        $options = [];
        $options[] = "text='" . $text . "'";
        //$options[] = 'fontfile=OpenSans-Regular.ttf';
        $options[] = "fontfile='c\:/dev/clips/storage/fonts/Roboto-Regular.ttf'";
        $options[] = 'fontcolor=white';
        $options[] = 'fontsize=30';
        $options[] = 'x=(w-text_w)/2';
        $options[] = 'y=(h)-h/10';

        $command = implode(':', $options);

        $this->video->filters()->custom("drawtext=$command");
    }

    public function drawRect(): void
    {
        $options = [];
        $options[] = 'istream: x=0';

        $options[] = 'x=0';
        $options[] = "y='ih-ih/6'";

        $options[] = "width='iw'";
        $options[] = "height='ih/6'";

        $options[] = "color=" . $this->boxColor;
        $options[] = "t='fill'";

        $command = implode(':', $options);
        $this->video->filters()->custom("drawbox=$command");
    }

    public function save(string $path): void
    {
        $this->pathOut = OUT_DIR . $path;
        $this->video->save(new \FFMpeg\Format\Video\X264(), $this->pathOut);
    }

    public function setOffset(float $start, float $end)
    {
        $this->timeOffsetL = $start;
        $this->timeOffsetR = $end;
    }


}