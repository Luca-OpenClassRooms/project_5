<?php

namespace App\Core;

class Config
{
    /**
     * Config data
     *
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        $files = scandir("../config");
        array_shift($files);
        array_shift($files);
        
        foreach ($files as $file) {
            $data = @include_once "../config/".$file;
            $name = str_replace(".php", "", $file);

            $this->data[$name] = $data;
        }
    }

    /**
     * Get a config value
     *
     * @param string $name
     * @return void
     */
    public function get(string $name)
    {
        $part = explode(".", $name);
        $data = $this->data[$part[0]];

        array_shift($part);

        foreach ($part as $p) {
            $data = $data[$p];
        }

        return $data;
    }
}
