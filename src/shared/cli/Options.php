<?php
namespace PharIo\Phive\Cli;

use PharIo\Phive\OptionParser;

class Options {

    /**
     * @var OptionParser
     */
    private $optionParser;
    
    /**
     * @var string[]
     */
    private $switches = [];

    /**
     * @var string[]
     */
    private $options = [];

    /**
     * @var string[]
     */
    private $arguments = [];

    /**
     * @param $optionParser
     * @param string[] $options
     */
    public function __construct($optionParser, array $options) {
        $this->extractArguments($options);
        foreach ($this->optionParser->parse($options) as $parsedOption) {
            if ($parsedOption instanceof ParsedFlag) {
                $this->switches[] = $parsedOption->getName();
            }
            if ($parsedOption instanceof ParsedOption) {
                $this->options[$parsedOption->getName()] = $parsedOption->getValue();
            }
        }
    }

    /**
     * @param array $options
     */
    private function extractArguments(array $options) {
        foreach ($options as $idx => $option) {
            if (preg_match('/^-.*/', $option)) {
                continue;
            }
            $this->arguments[] = $option;
        }
    }

    /**
     * @param $name
     *
     * @return string
     * @throws CommandOptionsException
     */
    public function getOption($name) {
        if (!$this->hasOption($name)) {
            throw new CommandOptionsException(
                sprintf('No option with name %s', $name),
                CommandOptionsException::NoSuchOption
            );
        }
        return $this->options[$name];
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasOption($name) {
        return isset($this->options[$name]);
    }

    public function isSwitch($switch) {
        return isset($this->switches[$switch]);
    }

    public function getArgumentCount() {
        return count($this->arguments);
    }

    public function getArgument($index) {
        if (!$this->hasArgument($index)) {
            throw new CommandOptionsException(
                sprintf('No argument at index %s', $index),
                CommandOptionsException::InvalidArgumentIndex
            );
        }
        return $this->arguments[$index];
    }

    public function hasArgument($index) {
        return isset($this->arguments[$index]);
    }

    public function getArguments() {
        return $this->arguments;
    }
}
