<?php
namespace PharIo\Phive;

class Option {

    private $name = '';

    private $hasValue = false;

    private $isRequired = false;
    
    private $shortName;

    /**
     * @param string $name
     * @param bool $hasValue
     * @param bool $isRequired
     * @param null $shortName
     */
    public function __construct($name, $hasValue, $isRequired, $shortName = null) {
        $this->name = $name;
        $this->hasValue = $hasValue;
        $this->isRequired = $isRequired;
        $this->shortName = $shortName;
    }

    public function getName() {
        return $this->name;
    }

    public function hasValue() {
        return $this->hasValue;
    }

    public function isRequired() {
        return $this->isRequired;
    }

    /**
     * @return bool
     */
    public function hasShortName() {
        return $this->shortName !== null;
    }

    /**
     * @return string
     */
    public function getShortName() {
        return $this->shortName;
    }
}