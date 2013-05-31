
<?php 
/**
 * Short description for file.
 *
 * PHP versions 4 and 5
 * 
 * cycle_detection.php
 * @author Zaria Ruiz
 */
 
 // sample class usage
   if (count($argv) > 1) {
      // object creation
      $file = new TextFile($argv[1]);
	  $file->cycle_detection();
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
	 
	 // print cycles of lines in the file
	 function cycle_detection() {
	     $input = $this->open_file();
		 if ($input) {
		  // var initialization
		  $i = 0;
		  $array = array();
		  $result = array();
		  try {
		  while (!feof($input)) {
		    $line = fgets($input);
			if (strlen($line) > 1) {
			    $line = trim($line, "\n");
			    $array[$i] = explode(" ", $line);
			    $result[$i] = brent_algorithm($array[$i]); // detecting cycles 
				$j = 0;	
                $k = $result[$i][0];  // cycle length 
                $l = 0;				
				while ($k > 0)  {
				 while ($j != $result[$i][1] ) 
				     $j++;
				  
				 if ($k == 1) 
				   $cycle = $cycle.$array[$i][$j+$l]." \n";
				 else $cycle = $cycle.$array[$i][$j+$l];
				 $l++;
				 $k--;
				}
				print_r($cycle); 
			}
			$i ++;
			$cycle = '';
		 }
         fclose($input);
		 } catch (Exception $e) {
           echo 'Caught exception: ',  $e->getMessage(), "\n"; }
		 }
		 else
		 print ("The file cannot be open");
	 }
}
     
     // brent algorithm O(l+m) time and O(1) space complexity. 
	 function brent_algorithm($array) {
		 $i = 1;
		 $p = 1;
		 $l = 1;
		 $x = $array[0];
		 $y = $array[1];
		
		 // find the length of cycle $l
		 while ($x != $y) {
		  if ($p == $l) {  		      
		   $x = $y;
		   $p *= 2;
		   $l = 0;
		  }
          $y = $array[$i+1];
		  $l++;
		  $i++; 
		 }
		 // find the position of the first repetition of length $m
		 $x = $array[0];
		 $y = $array[0];
		 for ($j = 0; $j<$l; $j++) {
		   $y = $array[$j+1];
		 } 
		 $k = 0;
		 $n = $j;
		 $m = 0;
		 while ($x != $y ) {
		   $x = $array[$k+1];
		   $y = $array[$n+1];
           $m++;
		   $k++;
		   $n++;
 		 }
		 $result = array();
		 $result[0] = $l;
		 $result[1] = $m;
		 return $result;
	 }
?>


