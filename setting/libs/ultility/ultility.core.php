<?php
namespace PHPEasy\Cores;
class _Ultility{
	public static function ConsoleData($data) {
		echo (is_array($data)?"<script>console.log( 'Debug Objects: " . implode( '\n', $data) . "' );</script>":"<script>console.log( 'Debug Objects: " . $data . "' );</script>");
	}
}
?>