<?php
namespace PharIo\Phive\PharRegressionTests;

class InstallCommandTest extends PharTestCase {

    public function testInstallsPhar() {
        $this->changeWorkingDirectory(__DIR__ . '/tmp');
        $result = $this->runPhiveCommand('install', ['phpunit'], ['temporary']);

        $this->assertFileExists(__DIR__ .'/tmp/tools/phpunit');
    }

}