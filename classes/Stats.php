<?php

/**
 * Class Lp
 * handles the user's Lp and logout process
 */
class Stats
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
    
    public $result = array();

    public function __construct()
    {
    	//pdo
    	try
    	{
    		$this->db_connection =  new PDO('pgsql:host='.DB_HOST.';port=5432;dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
    	
    	}
    	catch(PDOException $e)
    	{
    		echo $e->getMessage();
    	}
    }
    /**
     * 
     */
    public function doGetStats($page)
    {
		//pdo
		$sql = "select * from tracker WHERE page LIKE "."'". htmlspecialchars($page)."'";
		$this->result = $this->db_connection->query($sql);
		if ($this->result->rowCount() > 1) {
			// show the number
			return $this->result->rowCount();
		}
    }
    
    public function doGetDistinctStats($page)
    {
    	//pdo
    	$sql = "SELECT DISTINCT ip FROM tracker WHERE page LIKE "."'". htmlspecialchars($page)."'";
    	$this->result = $this->db_connection->query($sql);
    	if ($this->result->rowCount() > 0) {
    		// show the number
    		return $this->result->rowCount();
    	}
    }

}
