<?php


namespace App;


class Subs
{

    private $subs = [];
    private $files = [];
    private $dir = '';

    public function __construct(string $text)
    {
        $this->dir = '';

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
                    'text'  => $line
                ];
            }
        }
    }

    public function count()
    {
        return count($this->subs);
    }

}