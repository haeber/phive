<?php
namespace PharIo\Phive;

use PharIo\Phive\Cli\ParsedFlag;
use PharIo\Phive\Cli\ParsedOption;

class OptionParserTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider optionsProvider
     *
     * @param array $options
     * @param array $configuredOptions
     * @param array $expectedOptions
     */
    public function testReturnsExpectedOptions(array $options, array $configuredOptions, array $expectedOptions) {
        $parser = new OptionParser($configuredOptions);
        $actualOptions = $parser->parse($options);

        $this->assertEquals($expectedOptions, $actualOptions);
    }

    public static function optionsProvider() {
        return [
            [
                ['--foo', 'bar'],
                [new Option('foo', true, false)],
                [new ParsedOption('foo', 'bar')]
            ],
            [
                ['--foo', '--bar'],
                [new Option('foo', false, false)],
                [new ParsedFlag('foo')]
            ],
            [
                ['--foo', '--bar'],
                [
                    new Option('foo', false, false),
                    new Option('bar', false, false)
                ],
                [
                    new ParsedFlag('foo'),
                    new ParsedFlag('bar')
                ]
            ],
        ];
    }

}
