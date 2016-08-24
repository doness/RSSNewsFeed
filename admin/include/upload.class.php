<?php
class fileDir {
	  private $fileInfo;
	  private $fileLocation;
	  private $error;
	  private $direct;
	   
	  function __construct($dir){
	      $this->direct = $dir;
	      if(!is_dir($this->direct)){
	          die('Supplied directory is not valid: '.$this->direct);   
	      }
	  }
	  
	  function upload($theFile){
	      $this->fileInfo = $theFile;
		  $ext = strtolower(substr(strrchr($this->fileInfo['name'],'.'),1));
		  $filename = rand(0000,9999).time().'.'.$ext;
	      $this->fileLocation = $this->direct . $filename;
	        if(move_uploaded_file($this->fileInfo['tmp_name'], $this->fileLocation)){
	            return $filename;
	        } else {
	            return 'File could not be uploaded';
	            $this->error = "Error: File could not be uploaded.\n";
	            $this->error .= 'Here is some more debugging info:';
	            $this->error .= print_r($_FILES);   
	        }
	  }
	  
	  function overwrite($theFile){
	      $this->fileInfo = $theFile;
	      $this->fileLocation = $this->direct . $this->fileInfo['name'];
	      if(file_exists($this->fileLocation)){
	          $this->delete($this->fileInfo['name']);
	      }
	      return $this->upload($this->fileInfo);
	  }
	  
	  function location(){
	      return $this->fileLocation;   
	  }
	  
	  function fileName(){
	      return $this->fileInfo['name'];
	  }
	  
	  function delete($fileName){
	      $this->fileLocation = $this->direct.$fileName;
	      if(is_file($this->fileLocation)){
	        @unlink($this->fileLocation);
	        return 'Your file was successfully deleted';
	      } else {
	        return 'No such file exists: '.$this->fileLocation; 
	      }
	  }
	  
	  function reportError(){
	      return $this->error;  
	  }
	}
?>