<?php


namespace App\Commands;


use App\Movie;
use App\Subs;

class Main
{

    public function start()
    {
        $subs = new Subs('Well, peer-to-peer delivery');
        $items = $subs->get();

        foreach ($items as $item) {
            $movie = new Movie($item['filename'] . '.mkv');
            $movie->setOffset(0, 0.05);
            $movie->cut($item['time']['start'], $item['time']['duration']);
            //$movie->drawRect();
            //$movie->drawText($item['text']);
            $movie->save($item['time']['start'] . $item['filename'] . '.mp4');
        }
    }

}