<?php
namespace MagentoHackathon\Composer\Magento;

class ModmanParserTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ModmanParser
     */
    protected $object;

    /**
     * @var string
     */
    protected $modmanFileDir;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $baseTestClassName = substr(basename(__FILE__), 0, -4);
        $this->modmanFileDir = __DIR__ . '/data/' . $baseTestClassName . '/';
        $this->object = new ModmanParser();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown(): void
    {
    }

    /**
     * @covers MagentoHackathon\Composer\Magento\ModmanParser::setModuleDir
     * @covers MagentoHackathon\Composer\Magento\ModmanParser::getModuleDir
     */
    public function testSetGetModuleDir()
    {
        $dirName = 'test/dummy/dir';
        $this->object->setModuleDir($dirName);
        $this->assertSame($dirName, $this->object->getModuleDir());
    }

    public function testSetSetModuleDirWithTrailingSlash()
    {
        $this->object->setModuleDir('test/');
        $this->assertSame('test', $this->object->getModuleDir());
    }

    public function testSetSetModuleDirWithTrailingBackslash()
    {
        $this->object->setModuleDir('test\\');
        $this->assertSame('test', $this->object->getModuleDir());
    }

    /**
     * @covers MagentoHackathon\Composer\Magento\ModmanParser::setFile
     * @covers MagentoHackathon\Composer\Magento\ModmanParser::getFile
     */
    public function testSetGetFile()
    {
        $file = $this->getMockBuilder('\\SplFileObject')->setConstructorArgs([__FILE__])->getMock();
        $this->object->setFile($file);
        $this->assertSame($file, $this->object->getFile());
    }

    /**
     * @covers MagentoHackathon\Composer\Magento\ModmanParser::getMappings
     */
    public function testGetMappings()
    {
        $expected = [
            ['line/with/tab', 'record/one'],
            ['line/with/space', 'record/two'],
            ['line/with/space/and/tab', 'record/three']
        ];
        $this->object->setFile($this->modmanFileDir . 'modman');
        $this->assertSame($expected, $this->object->getMappings());
    }
}
