<?php

class mods {
	public static function load()
	{
		global $spl_root;
		
		// list mods
		$exclude = [
			'.',
			'..',
			'.htaccess',
			'examplemod.txt',
			'index.php'
		];

		$scan = scandir($spl_root . 'mods');
		$files = array_diff($scan, $exclude);

		//dd($files);

		$loaded_mods = [];

		foreach($files as $filename){
			$file = file_get_contents($spl_root . 'mods/' . $filename);	
			$array = explode(PHP_EOL, $file);
			
			if(count($array) != 5){
				die("<strong>Misconfiguration in: mods/" . $filename . "</strong><br><strong>Error:</strong> Mod file doesn't have exactly 5 lines");
			}
			
			$keys = [
				'Name',
				'Author',
				'Description',
				'Version',
				'URL'
			];
			
			foreach($array as $k => $line){
				$found = stripos($line, $keys[$k] . ':');
				if($found === false){
					die("<strong>Misconfiguration in: mods/" . $filename . "</strong><br><strong>Key is wrong at line:</strong> " . $line);
				}
			}
			
			$loaded_mods[] = $array;
		}
		
		return $loaded_mods;
	}
}