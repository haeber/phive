<?php
namespace PharIo\Phive\Cli;

class ParsedOption {

    private $name;
    
    private $value;

    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value) {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }
    

}