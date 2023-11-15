<?php
use PHPUnit\Framework\TestCase;

require_once 'Logger.php';

// RUN: vendor/bin/phpunit test
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

    // 文字列が正しくファイルに書き込まれるかテスト
    public function testStringWriteToLog()
    {
        $data = "test";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("test\r\n", file_get_contents($this->testFilePath));
    }

    // 数値が正しくファイルに書き込まれるかテスト
    public function testIntegerWriteToLog()
    {
        $data = 100;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("100\r\n", file_get_contents($this->testFilePath));
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
