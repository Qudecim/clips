<?php


namespace App;


class Subs
{

    private $subs = [];
    private $files = [];
    private $dir = '';

    public function __construct(string $text)
    {
        $this->dir = dirname(__FILE__) . '/../storage/sub/';

        $this->files = array_diff(scandir($this->dir), array('..', '.'));

        foreach ($this->files as $file) {
            $this->search($file, $text);
        }

    }

    public function search(string $file, string $text)
    {
        $lines = file($this->dir . $file);

        foreach ($lines as $index => $line) {
            if( strpos($line, $text) !== false ) {
                $fileInfo = pathinfo($file);
                $this->subs[] = [
                    'dir'       => $this->dir,
                    'file'      => $file,
                    'filename'  => $fileInfo['filename'],
                    'extension' => $fileInfo['extension'],
                    'line'      => $index,
                    'text'      => trim($line),
                    'time'      => $this->getTime($lines, $index)
                ];
            }
        }
    }

    public function getTime(array $lines, int $index): array
    {
        $line = '';
        for ($i = $index; $i > 0; $i--) {
            if (strpos($lines[$i], '-->')) {
                $line = $lines[$i];
                break;
            }
        }

        $times = [];
        $array = explode('-->', $line);
        $start = $this->getSeconds(trim(str_replace(',', '.', $array[0])));
        $end =  $this->getSeconds(trim(str_replace(',', '.', $array[1])));
        return [
            'start' => $start,
            'end' => $end,
            'duration' => round($end - $start, 3)
        ];
    }

    public function getSeconds(string $str): float
    {
        $seconds = 0;
        $times = explode(':', $str);
        return (floatval($times[0] * 3600)) + (floatval($times[1] * 60)) + floatval($times[2]);
    }

    public function get()
    {
        return $this->subs;
    }

    public function count()
    {
        return count($this->subs);
    }

}