<?php 
/**
 * Short description for file.
 *
 * PHP versions 4 and 5
 * 
 * reverse_words.php
 * @author Zaria Ruiz
 */
 
// sample class usage
if (count($argv) > 1) {
      // object creation
      $file = new TextFile($argv[1]);
	  $file->reverse_words();
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
	 
	 // reverse the words of a file sentence
	 function reverse_words() {
	     $input = $this->open_file();
		 if ($input) {
		 // var initialization
		 $i = 0;
		 $array = array();
		 try {
		 while (!feof($input)) {
		    $line = fgets($input);
			if (strlen($line) > 1) {
			  $line = trim($line, "\n");
			  $words = explode(" ", $line);
			  $array[$i] = $words;
			  $i++;
	        }
		 }
		 fclose($input);
		 for ($k=0;$k<count($array);$k++){
		  for ($j=count($array[$k])-1;$j>=0;$j--){
		    if ($j==0) 
              $string = $string.$array[$k][$j]." \n"." \n";
			else 
			  $string = $string.$array[$k][$j]." "; 
		  }
		 }
		 echo "\n".$string;
		 } catch (Exception $e) {
           echo 'Caught exception: ',  $e->getMessage(), "\n"; }
		 }
		 else
		 print ("The file cannot be open");
	 }
}
?>


