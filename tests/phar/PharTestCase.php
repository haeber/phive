<?php
namespace PharIo\Phive\PharRegressionTests;

class PharTestCase extends \PHPUnit_Framework_TestCase {

    private $pharSize = 0;

    final protected function setUp() {
        $this->pharSize = filesize(PHAR_FILENAME);

        if (!file_exists(__DIR__ . '/tmp')) {
            mkdir(__DIR__ . '/tmp');
        }
        $this->_setUp();
    }

    final protected function tearDown() {
        if (file_exists(__DIR__ . '/tmp')) {
            $this->removeDirectory(__DIR__ . '/tmp');
        }
        $this->assertPharIsUnchanged();
        $this->_tearDown();
    }

    protected function _setUp() {

    }

    protected function _tearDown() {

    }

    /**
     * @param string $directory
     */
    protected function changeWorkingDirectory($directory) {
        chdir($directory);
    }

    /**
     * @param $command
     * @param array $arguments
     * @param array $switches
     *
     * @return mixed
     */
    protected function runPhiveCommand($command, array $arguments = [], array $switches = []) {
        $call = PHAR_FILENAME . ' ' . $command;
        foreach ($switches as $switch) {
            $call .= ' -' . $switch;
        }
        foreach ($arguments as $argument) {
            $call .= ' ' . $argument;
        }
        $call .= ' 2>&1';
        @exec($call, $outputLines, $resultCode);

        $output = '';

        foreach ($outputLines as $line) {
            $output .= $line . "\n";
        }

        if ($resultCode !== 0) {
            throw new \RuntimeException($output);
        }

        return $output;
    }

    /**
     * @param $path
     */
    private function removeDirectory($path) {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectory($file) : unlink($file);
        }
        rmdir($path);

        return;
    }

    private function assertPharIsUnchanged() {
        if ($this->pharSize !== filesize(PHAR_FILENAME)) {
            $this->fail('PHAR was changed during the test!');
        }
    }
}