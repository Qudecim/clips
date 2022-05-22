<?php


namespace App\Commands;


use App\Movie;
use App\Subs;

class Main
{

    public function start()
    {
        $d = new Subs('PLAYING');
        return;
        $pathIn = '../storage/movie/1.mp4';
        $pathOut = 'export-x264.mp4';

        echo 1;
        $movie = new Movie($pathIn);
        echo 2;
        $movie->cut(0, 5);
        echo 3;
        $movie->save($pathOut);
        echo 4;
    }

}