<?php
use PHPUnit\Framework\TestCase;

require_once 'Logger.php';

// TEST RUN: vendor/bin/phpunit test
class LoggerTest extends TestCase
{
    // テストファイルのパス
    private $testFilePath = 'test.log';

    // テストケースのセットアップ
    protected function setUp(): void
    {
        // 事前にテストファイルが存在していたら削除
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    // テストケースのクリーンアップ
    protected function tearDown(): void
    {
        // テストが終了したらテストファイルを削除
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    // 検証データが引数に設定されていない場合、初期値がファイルに書き込まれるかテスト
    public function testDataNotSetWriteToLog()
    {
        Logger::dumpLog($this->testFilePath);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("The data to be verified is not set.\r\n", file_get_contents($this->testFilePath));
    }

    // 文字列が正しくファイルに書き込まれるかテスト
    public function testStringWriteToLog()
    {
        $data = "test";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("test\r\n", file_get_contents($this->testFilePath));
    }

    // 文字列（空）が正しくファイルに書き込まれるかテスト
    public function testStringEmptyWriteToLog()
    {
        $data = "";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("\r\n", file_get_contents($this->testFilePath));
    }

    // 文字列（ゼロ）が正しくファイルに書き込まれるかテスト
    public function testStringZeroWriteToLog()
    {
        $data = "0";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("0\r\n", file_get_contents($this->testFilePath));
    }

    // 数値が正しくファイルに書き込まれるかテスト
    public function testIntegerWriteToLog()
    {
        $data = 100;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("100\r\n", file_get_contents($this->testFilePath));
    }

    // 数値（ゼロ）が正しくファイルに書き込まれるかテスト
    public function testIntegerZeroWriteToLog()
    {
        $data = 0;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("0\r\n", file_get_contents($this->testFilePath));
    }

    // ブール値（True）が正しくファイルに書き込まれるかテスト
    public function testBoolTrueWriteToLog()
    {
        $data = true;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("True\r\n", file_get_contents($this->testFilePath));
    }

    // ブール値（False）が正しくファイルに書き込まれるかテスト
    public function testBoolFalseWriteToLog()
    {
        $data = false;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("False\r\n", file_get_contents($this->testFilePath));
    }

    // null値が正しくファイルに書き込まれるかテスト
    public function testNullWriteToLog()
    {
        $data = null;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("Null\r\n", file_get_contents($this->testFilePath));
    }

    // 配列が正しくファイルに書き込まれるかテスト
    public function testArrayWriteToLog()
    {
        $data = ['line1', 'line2', 'line3'];
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("line1\r\nline2\r\nline3\r\n", file_get_contents($this->testFilePath));
    }

    // オブジェクトが正しくファイルに書き込まれるかテスト
    public function testObjectWriteToLog()
    {
        $data = new stdClass();
        $data->name = 'John';
        $data->age = 31;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("(object) array(\n   'name' => 'John',\n   'age' => 31,\n)\r\n", file_get_contents($this->testFilePath));
    }
}
