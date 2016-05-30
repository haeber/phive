<?php
namespace PharIo\Phive;

use PharIo\Phive\Cli\ParsedFlag;
use PharIo\Phive\Cli\ParsedOption;

class OptionParser {

    /**
     * @var Option[]
     */
    private $configuredOptions = [];

    /**
     * @param array $configuredOptions
     */
    public function __construct(array $configuredOptions) {
        $this->configuredOptions = $configuredOptions;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function parse(array $options) {
        $parsedOptions = [];
        foreach ($options as $index => $option) {
            foreach ($this->configuredOptions as $availableOption) {
                if (!$this->optionMatches($option, $availableOption)) {
                    continue;
                }
                if ($availableOption->hasValue()) {
                    $value = $options[$index + 1];
                    $parsedOptions[] = new ParsedOption($availableOption->getName(), $value);
                    unset($options[$index+1]);
                } else {
                    $parsedOptions[] = new ParsedFlag($availableOption->getName());
                }
            }
        }
        return $parsedOptions;
    }

    /**
     * @param $option
     * @param Option $availableOption
     *
     * @return bool
     */
    private function optionMatches($option, Option $availableOption) {
        return preg_match(sprintf('/^--%s$/', $availableOption->getName()), $option) ||
        preg_match(sprintf('/^-%s$/', $availableOption->getShortName()), $option);
    }
    
}