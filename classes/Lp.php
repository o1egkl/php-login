<?php

/**
 * Class Lp
 * handles the user's Lp and logout process
 */
class Lp
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();
    
    public $title='';
    
    public $html='';

    /**
     * 
     */
    public function doLpAdd()
    {
        // add new LP
        if(empty($_POST['text1'])){
        	$this->errors[] = "The file content is empty.";
        }
        if(empty($_POST['title'])){
        	$this->errors[] = "Title is missing.";
        	
        }
        if(!empty($_POST['text1']) && !empty($_POST['title'])){
        	$html = $_POST['text1'];
        	$file = $_POST['title'].'.php';
        	file_put_contents('LP/'.$file, $html);
        	return true;
        }
        return false;
    }

    /**
     * 
     */
    public function doLpList()
    {
    	if ($handle = opendir('LP')) {
    		while (false !== ($entry = readdir($handle))) {
    			if ($entry != "." && $entry != "..") {
    				echo '<li><a href="LP/'.$entry.'" target="new">'.$entry.'</a>&nbsp;<a href="edit.php?title='.$entry.'">Edit</a>&nbsp;<a href="stats.php?page='.substr($entry,0,strpos($entry,'.php')).'">Stats</a></li>';
    			}	
    		}
    	
    		closedir($handle);
    	}

    }

    /**
     * 
     */
    public function doLpEdit($title)
    {
        $this->html = file_get_contents('LP/'.$title);
        $this->title =$title;
    }
}
