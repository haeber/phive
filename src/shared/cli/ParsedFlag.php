<?php
namespace PharIo\Phive\Cli;

class ParsedFlag {

    private $name;
    
    /**
     * @param $name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }
    
}