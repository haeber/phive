<?php
namespace PharIo\Phive;

class PharTestBootstrap {

    public function run() {
        $this->buildPhar();
        $this->createPharRegistry();
    }

    private function buildPhar() {
        echo "Building PHAR... \n";

        chdir(__DIR__ . '/../..');
        @exec('ant phar', $output ,$returnCode);
        if ($returnCode !== 0) {
            throw new \RuntimeException('Could not build PHAR');
        }

        $filename = glob(__DIR__ . '/../../build/phar/*.phar')[0];
        echo sprintf("Using PHAR %s for the test run. \n\n", $filename);

        $this->createPharRegistry();
    }

    private function createPharRegistry() {
        $xmlFilename = __DIR__ . '/fixtures/phive-home/phars.xml';
        if (file_exists($xmlFilename)) {
            unlink($xmlFilename);
        }
        $registry = new PharRegistry(
            new XmlFile(new Filename($xmlFilename), 'https://phar.io/phive/installdb', 'phars'),
            new Directory(__DIR__ . '/fixtures/phive-home/phars')
        );
        $registry->addPhar(
            new Phar('phpunit', new Version('5.3.1'), new File(new Filename('phpunit-5.3.1.phar'), 'foo'))
        );
    }

}