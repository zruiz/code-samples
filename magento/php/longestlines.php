<?php 
/**
 * Short description for file.
 *
 * PHP versions 4 and 5
 * 
 * longestlines.php
 * @author Zaria Ruiz
 */
 
 // sample class usage
   if (count($argv) > 1) {
      // object creation
      $file = new TextFile($argv[1]);
	  $file->longest_lines();
   } else {
      print("\n Please specify a file path name.\n");
      exit();
   }

 // class definition  
 class TextFile {
    // var declaration
    var $filePath;
	
	// constructor declaration
	function TextFile($path){
        $this->filePath = $path;
    }	
	 
    // methods declaration
	
	// open file	
    function open_file() {
	 try {
	    $input = fopen($this->filePath, "rt");
		return $input;
	 } catch (Exception $e) {
     echo 'Caught exception: ',  $e->getMessage(), "\n"; }
    }
	
	// read file
	function read_file() {
	     $input = $this->open_file();
		 if ($input) {
		 while (!feof($input)) {
            $buffer = fread($input);
		 }
         fclose($input);
         return $buffer;
		 }
		 else
		 print ("The file cannot be open");
	 }
	 
	 // print the n longest lines of the file
	 function longest_lines() {
	     $input = $this->open_file();
		 if ($input) {
		 // var initialization
		 $i = 0;
		 $lineCount = 0;
		 $file = array();
		 try {
		 while (!feof($input)) {
		  if ($i == 0) {
            $lineCount = fgets($input);}
		  else {
		    $line = fgets($input);
			// array file creation
			$file[$i] = array 
			( 'string' => $line,
			  'length' => strlen($line),
			);
	     }
		 $i++;
		 }
         fclose($input);
		 
         foreach ($file as $key => $row) {
            $string[$key]  = $row['string'];
            $length[$key] = $row['length'];
         }

         // array file sort
         array_multisort($length, SORT_DESC, $string, SORT_ASC, $file);
		 
		 // display results
		 for ($j=0;$j<$lineCount;$j++){
            echo "\n".$file[$j]['string']."\n"; 
		 }
		 } catch (Exception $e) {
           echo 'Caught exception: ',  $e->getMessage(), "\n"; }
		 }
		 else
		 print ("The file cannot be open");
	 }
 }
?>

