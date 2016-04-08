<?php
namespace PharIo\Phive\PharRegressionTests;

class InstallCommandTest extends PharTestCase {

    public function testInstallsPhar() {
        $this->changeWorkingDirectory(__DIR__ . '/tmp');
        $this->runPhiveCommand('install', ['phpunit']);

        $this->assertFileExists(__DIR__ .'/tmp/tools/phpunit');
    }

}