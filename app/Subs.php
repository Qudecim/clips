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
                $this->subs[] = [
                    'dir'   => $this->dir,
                    'file'  => $file,
                    'line'  => $index,
                    'text'  => $line,
                    'time'  => $this->getTime($lines, $index)
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
        for ($i = 0; $i <= 1; $i++) {
            echo $i;
            $times[] = $this->getSeconds(trim(str_replace(',', '.', $array[$i])));
        }

        return $times;
    }

    public function getSeconds(string $str): int
    {
        $seconds = 0;
        $times = explode(':', $str);
        for ($i = 0; $i <= 2; $i++) {
            $seconds += floatval($times[$i]);
        }

        return $seconds;
    }


    public function count()
    {
        return count($this->subs);
    }

}