<?php
/**
 * ロガー（デバッグ用）
 */
class Logger {
    /**
     * ログファイルに変数or配列の中身を書き出す
     * @param string $logpath データを書き込むファイルのパス（初期値：debug.log）
     * @param mixed $data ファイルに書き込むデータ（初期値：The data to be verified is not set.）
     * @param string $mode ファイルの書き込みモード（初期値：w（上書きモード））
     * @return void
     */
    public static function dumpLog(string $logpath="debug.log", mixed $data="The data to be verified is not set.", string $mode="w"): void {
        try {
            // ファイルパスの拡張子取得
            $ext = substr($logpath, strrpos($logpath, '.') + 1);
            if ($ext !== "txt" && $ext !== "log") {
                throw new Exception("File extension should be txt or log.");
            }

            // ファイルを開く（存在しない場合は新規作成）
            $fileHandle = fopen($logpath, $mode);
            // ファイルが開けなかった場合、エラーログに追記して処理お返し
            if ($fileHandle === false) {
                error_log("Failed to open the file: {$logpath}");
                return;
            }

            // Null値の場合、なにも書き出されないのでNullの文字列に変換
            if (is_null($data)) {
                $data = "Null";
            }

            // ブール値の場合、1、0で書き出されるのでTrue、Falseの文字列に変換
            if (is_bool($data)) {
                if ($data === True) {
                    $data = "True";
                }
                if ($data === False) {
                    $data = "False";
                }
            }

            // 配列の場合：implode関数を使って文字列に変換
            if (is_array($data)) {
                $data = implode(PHP_EOL, $data);
            }

            // オブジェクトの場合：var_exportを使って文字列に変換
            if (is_object($data)) {
                $data = var_export($data, true);
            }

            // ファイルにデータを書き込み
            fwrite($fileHandle, $data . PHP_EOL);

            // ファイルを閉じる
            fclose($fileHandle);
        } catch (Exception $e) {
            // エラーログに例外エラー書き出し
            error_log("Exception " . __CLASS__ . "::" . __FUNCTION__  . " ". $e->getMessage());
        }
    }
}