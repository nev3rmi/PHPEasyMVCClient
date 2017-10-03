<?php
namespace PHPEasy\Cores;
class _View{
	public function Render($name, $upperLayout = null, $downerLayout = null, $noLayout = false, $noPartialLayout = false){
		if ($noLayout === true){
			require_once 'views/'.$name.'.php';
			if ($noPartialLayout === false){
				require_once 'views/_layout/_partialLayout.php';
			}
		}else{
			require_once 'views/_layout/_head.php';
			if ($upperLayout != null){
				$upperLayout = 'views/'.$upperLayout.'.php';
				if (file_exists($upperLayout)){
					require_once $upperLayout;
				}
			}
			require_once 'views/'.$name.'.php';
			if ($downerLayout != null){
				$downerLayout = 'views/'.$downerLayout.'.php';
				if (file_exists($downerLayout)){
					require_once $downerLayout;
				}
			}
			require_once 'views/_layout/_body.php';
		}
	}

	public function Content($data){
		echo $data;
	}

	public function RenderWithTheme($name, $layoutArray){
		
	}
}
?>