<?php
	require 'config.php';
	
	function getModels($basedir) {
		$models = array();
		
		$files = glob($basedir . 'model/*/*.php');
		foreach ($files as $file) {
			$dirs = explode('/', dirname($file));
			$dir = end($dirs);
			
			$parts = explode('_', basename($file, '.php'));
			foreach ($parts as &$part) {
				$part = ucfirst($part);
			}
			$models[] = 'Model' . ucfirst($dir) . implode('', $parts) . ' $model_' . $dir . '_' . basename($file, '.php');
		}
		
		return $models;
	}
	
	function getLibraries() {
		$libraries = array();
		
		$files = glob(DIR_SYSTEM . 'library/*.php');
		foreach ($files as $file) {
			$parts = explode('_', basename($file, '.php'));
			foreach ($parts as &$part) {
				$part = ucfirst($part);
			}
			// not clear how library classes with underscores should be named, so we follow model naming with stripped underscores
			$libraries[] = implode('', $parts) . ' $' . basename($file, '.php');
		}
		
		return $libraries;
	}
	
	$controllerPath = DIR_SYSTEM . 'engine/controller.php';
	$modelPath = DIR_SYSTEM . 'engine/model.php';
	$controllerSearchLine = 'abstract class Controller {';
	$modelSearchLine = 'abstract class Model {';
	
	$catalogPath = 'catalog/';
	$adminPath = 'admin/';
	
	//$properties = array('string $id', 'string $template', 'array $children', 'array $data', 'string $output', 'Loader $load');
	$properties = array();
	
	$html = '<html><head><script type="text/javascript" src="catalog/view/javascript/jquery/jquery-2.1.1.min.js"></script></head><body>';
	
	$libraries = getLibraries();
	$catalogModels = getModels(DIR_APPLICATION);
	$adminModels = getModels(str_ireplace($catalogPath, $adminPath, DIR_APPLICATION));
	
	$textToInsert = array_unique(array_merge($properties, $libraries, $catalogModels, $adminModels));
	
	if (is_writable($controllerPath)) {
		//regenerate Controller text with properties
		$file = new SplFileObject($controllerPath);
		$tempFile = sprintf("<?php %s \t/**%s", PHP_EOL, PHP_EOL);
		$tempFile .= sprintf("\t* @property Loader \$load\n");
		foreach ($textToInsert as $val) {
			$tempFile .= sprintf("\t* @property %s%s", $val, PHP_EOL);
		}
		$tempFile .= sprintf("\t**/%s%s%s", PHP_EOL, $controllerSearchLine, PHP_EOL);
		
		while (!$file->eof()) {
			if (strpos($file->fgets(), $controllerSearchLine) !== false) {
				break;
			}
		}
		while (!$file->eof()) {
			$tempFile .= $file->fgets();
		}
		
		//write Controller
		file_put_contents($controllerPath, $tempFile, LOCK_EX);
		
		$html .= '<h3>Controller Аutocomplete Properties Successfully Installed.</h3>';
	} else {
		$html .= '<h3>Place the following code above abstract class Controller in your system/engine/controller.php file</h3><hr>';
		
		$properties = '/**' . "\n";
		
		foreach ($textToInsert as $val) {
			$properties .= '* @property ' . $val . "\n";
		}
		
		$properties .= '**/' . "\n";
		
		$propnum = count($textToInsert);
		
		$html .= '<textarea rows="' . $propnum . '" cols="200" class="code">' . "\n";
		$html .= $properties;
		$html .= "</textarea>";
		$html .= '<hr>';
	}
	
	if (is_writable($modelPath)) {
		//regenerate Model text with properties
		$file = new SplFileObject($modelPath);
		$tempFile = sprintf("<?php %s \t/**%s", PHP_EOL, PHP_EOL);
		$tempFile .= sprintf("\t* @property Loader \$load\n");
		foreach ($textToInsert as $val) {
			$tempFile .= sprintf("\t* @property %s%s", $val, PHP_EOL);
		}
		$tempFile .= sprintf("\t**/%s%s%s", PHP_EOL, $modelSearchLine, PHP_EOL);
		
		while (!$file->eof()) {
			if (strpos($file->fgets(), $modelSearchLine) !== false) {
				break;
			}
		}
		while (!$file->eof()) {
			$tempFile .= $file->fgets();
		}
		
		//write Model
		file_put_contents($modelPath, $tempFile, LOCK_EX);
		
		$html .= '<h3>Model Аutocomplete Properties Successfully Installed.</h3>';
	} else {
		$html .= '<h3>Place the following code above abstract class Model in your system/engine/model.php file</h3><hr>';
		
		$properties = '/**' . "\n";
		
		foreach ($textToInsert as $val) {
			$properties .= '* @property ' . $val . "\n";
		}
		
		$properties .= '**/' . "\n";
		
		$propnum = count($textToInsert);
		
		$html .= '<textarea rows="' . $propnum . '" cols="200" class="code">' . "\n";
		$html .= $properties;
		$html .= "</textarea>";
		$html .= '<hr>';
	}
	
	$html .= '
		<script language="javascript" type="text/javascript">
			$(document).ready(function () {
				$(".code").focus(function() {
				    var $this = $(this);
				    $this.select();
				
				    // Work around Chromes little problem
				    $this.mouseup(function() {
				        // Prevent further mouseup intervention
				        $this.unbind("mouseup");
				        return false;
				    });
				});
			});
		</script>';
	$html .= "</body></html>";
	echo $html;
	