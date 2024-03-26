<?php
use PHPUnit\Framework\TestCase;

require_once 'Logger.php';

class LoggerTest extends TestCase {
    // テストファイルのパス
    private $testFilePath = 'test.log';

    /**
     * テストケースのセットアップ
     */
    protected function setUp(): void {
        // 事前にテストファイルが存在していたら削除
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    /**
     * テストケースのクリーンアップ
     */
    protected function tearDown(): void {
        // テストが終了したらテストファイルを削除
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    /**
     * 検証データが引数に設定されていない場合、初期値がファイルに書き込まれるかテスト
     */
    public function testDataNotSetWriteToLog() {
        Logger::dumpLog($this->testFilePath);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("The data to be verified is not set.\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 文字列が正しくファイルに書き込まれるかテスト
     */
    public function testStringWriteToLog() {
        $data = "test";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("test\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 文字列（空）が正しくファイルに書き込まれるかテスト
     */
    public function testStringEmptyWriteToLog() {
        $data = "";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 文字列（ゼロ）が正しくファイルに書き込まれるかテスト
     */
    public function testStringZeroWriteToLog() {
        $data = "0";
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("0\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 数値が正しくファイルに書き込まれるかテスト
     */
    public function testIntegerWriteToLog() {
        $data = 100;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("100\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 数値（ゼロ）が正しくファイルに書き込まれるかテスト
     */
    public function testIntegerZeroWriteToLog() {
        $data = 0;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("0\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * ブール値（True）が正しくファイルに書き込まれるかテスト
     */
    public function testBoolTrueWriteToLog() {
        $data = true;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("True\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * ブール値（False）が正しくファイルに書き込まれるかテスト
     */
    public function testBoolFalseWriteToLog() {
        $data = false;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("False\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * null値が正しくファイルに書き込まれるかテスト
     */
    public function testNullWriteToLog() {
        $data = null;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("Null\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 配列が正しくファイルに書き込まれるかテスト
     */
    public function testArrayWriteToLog() {
        $data = ['line1', 'line2', 'line3'];
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("line1\r\nline2\r\nline3\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * オブジェクトが正しくファイルに書き込まれるかテスト
     */
    public function testObjectWriteToLog() {
        $data = new stdClass();
        $data->name = 'John';
        $data->age = 31;
        Logger::dumpLog($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertEquals("(object) array(\n   'name' => 'John',\n   'age' => 31,\n)\r\n", file_get_contents($this->testFilePath));
    }

    /**
     * 拡張子が txt か log 以外だった場合、例外が発生するかテスト
     * @runInSeparateProcess
     */
    public function testvalidateFileExtension() {
        $this->expectException(Exception::class);
        // 例外のメッセージを設定
        $this->expectExceptionMessage('File extension should be txt or log.');
        // privateメソッドをテストするのでReflectionClass使用
        $logger = new ReflectionClass(Logger::class);
        $method = $logger->getMethod('validateFileExtension');
        $method->setAccessible(true);
        // 拡張子が invalid のファイルでテスト
        $logPath = 'test.invalid';
        $method->invoke(null, $logPath);
    }

    /**
     * writeToFileメソッドのテスト（引数$data有）
     * @runInSeparateProcess
     */
    public function testWriteToFileWithData() {
        $data = 'Test data';
        Logger::writeToFile($this->testFilePath, $data);
        $this->assertFileExists($this->testFilePath);
        $this->assertStringEqualsFile($this->testFilePath, $data . PHP_EOL);
    }

    /**
     * writeToFileメソッドのテスト（引数$data無）
     * @runInSeparateProcess
     */
    public function testWriteToFileWithoutData() {
        Logger::writeToFile($this->testFilePath);
        $this->assertFileExists($this->testFilePath);
        $this->assertStringEqualsFile($this->testFilePath, "The data to be verified is not set." . PHP_EOL);
    }

    /**
     * writeToFileメソッドのテスト（引数$mode="a"追記モード）
     * @runInSeparateProcess
     */
    public function testWriteToFileWithAppendMode() {
        $data1 = 'Test data 1';
        $data2 = 'Test data 2';
        Logger::writeToFile($this->testFilePath, $data1);
        Logger::writeToFile($this->testFilePath, $data2, 'a');
        $this->assertFileExists($this->testFilePath);
        $this->assertStringEqualsFile($this->testFilePath, $data1 . PHP_EOL . $data2 . PHP_EOL);
    }

    /**
     * ファイルを開くのに失敗した場合、例外が発生するかテスト
     * @runInSeparateProcess
     */
    public function testWriteToFileThrowsExceptionForInvalidPath() {
        $this->expectException(Exception::class);
        // 例外のメッセージを設定
        $this->expectExceptionMessageMatches('/^Failed to open the file:/');
        // 存在しないファイルのパス
        $logPath = '/path/to/non/existing/directory/test.log';
        $data = 'Test data';
        $mode = 'w';
        Logger::writeToFile($logPath, $data, $mode);
    }
}
