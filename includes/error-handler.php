<?php
set_error_handler('errorHandler');
set_exception_handler('exceptionHandler');

function exceptionHandler($e){
	if(error_reporting() == 0) return;

	switch($e->getCode()){
		case E_ERROR:
		case E_PARSE:
		case E_CORE_ERROR:
		case E_CORE_WARNING:
		case E_COMPILE_ERROR:
		case E_COMPILE_WARNING:
		case E_USER_ERROR:
			die('<div style="background:#cc0000;border:1px solid #990000;color:#fff;padding:5px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',Geneva,Verdana,Sans-Serif"><b>FATAL ERROR:</b> ' . $e->getMessage() . ' in file "' . $e->getFile() . '", line: ' . $e->getLine() . '<br /><span style="font-size:10px;">SolusVMController</span></div>');
		break;

		case E_WARNING:
		case E_NOTICE:
		case E_USER_WARNING:
		case E_USER_NOTICE:
		case E_STRICT:
		case E_RECOVERABLE_ERROR:
		case E_DEPRECATED:
		case E_USER_DEPRECATED:
		default:
			echo '<div style="background:#ff9900;border:1px solid #993300;color:#fff;padding:5px;font-family:\'Lucida Grande\',\'Lucida Sans Unicode\',Geneva,Verdana,Sans-Serif"><b>WARNING:</b> ' . $e->getMessage() . ' in file "' . $e->getFile() . '", line: ' . $e->getLine() . '<br /><span style="font-size:10px;">SolusVMController</span></div>';
		break;
	}
}

function errorHandler($no, $str, $file, $line){
	$e = new ErrorException($str, $no, 0, $file, $line);
	exceptionHandler($e);
}
?>