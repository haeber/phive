<?php
namespace PharIo\Phive;

    use Prophecy\Argument;
    use Prophecy\Prophecy\ObjectProphecy;
    use PharIo\Phive\Cli;

    /**
     * @covers PharIo\Phive\KeyService
     */
    class KeyServiceTest extends \PHPUnit_Framework_TestCase {

        /**
         * @var KeyDownloader|ObjectProphecy
         */
        private $downloader;

        /**
         * @var KeyImporter|ObjectProphecy
         */
        private $importer;

        /**
         * @var Cli\Output|ObjectProphecy
         */
        private $output;

        /**
         * @var Cli\Input|ObjectProphecy
         */
        private $input;

        public function setUp() {
            $this->downloader = $this->prophesize(KeyDownloader::class);
            $this->importer = $this->prophesize(KeyImporter::class);
            $this->output = $this->prophesize(Cli\Output::class);
            $this->input = $this->prophesize(Cli\Input::class);
        }

        public function testInvokesKeyDownloader() {
            $key = $this->prophesize(PublicKey::class)->reveal();
            $this->downloader->download('foo')->willReturn($key);

            $this->assertEquals($key, $this->getKeyService()->downloadKey('foo'));
        }

        public function testInvokesImporter() {
            $this->input->confirm(Argument::any())->willReturn(true);
            $this->importer->importKey('some key')->willReturn(['keydata']);

            $key = $this->prophesize(PublicKey::class);
            $key->getInfo()->willReturn('keyinfo');
            $key->getKeyData()->willReturn('some key');

            $this->assertEquals(['keydata'], $this->getKeyService()->importKey($key->reveal()));
        }

        /**
         * @expectedException \PharIo\Phive\VerificationFailedException
         */
        public function testImportKeyWillThrowExceptionIfUserDeclinedImport() {
            $this->markTestSkipped('Adjust logic');
            /*
            $this->input->confirm(Argument::any())
                ->willReturn(false);

            $this->getKeyService()->importKey('some id', 'some key');
            */
        }

        /**
         * @return KeyService
         */
        private function getKeyService() {
            return new KeyService(
                $this->downloader->reveal(), $this->importer->reveal(), $this->output->reveal(), $this->input->reveal()
            );
        }
    }

