<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Login
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

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        }
        // login via post data (if user just submitted a login form)
        elseif (isset($_POST["login"])) {
            $this->dologinWithPostData();
        }
    }
    
    public function __destruct(){
    	$this->db_connection= null;
    }

    /**
     * log in with post data
     */
    private function dologinWithPostData()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {
			
        	//PDO
            try {
            	$this->db_connection =  new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
            	/*** echo a message saying we have connected ***/
            	echo 'Connected to database<br />';
            	$user_name = strip_tags($_POST['user_name'],ENT_QUOTES);
            	/*** The SQL SELECT statement ***/
            	$sql = "SELECT user_name, user_email, user_password_hash
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "'";
            	$result_of_login_check = $this->db_connection->query($sql);
            	if ($result_of_login_check->rowCount() == 1) {
            	
            		// get result row (as an object)
            		$result_row = $result_of_login_check->fetchAll(PDO::FETCH_ASSOC);;
            	
            		// using PHP 5.5's password_verify() function to check if the provided password fits
            		// the hash of that user's password
            		if (password_verify($_POST['user_password'], $result_row[0]['user_password_hash'])) {
            	
            			// write user data into PHP SESSION (a file on your server)
            			$_SESSION['user_name'] = $result_row[0]['user_name'];
            			$_SESSION['user_email'] = $result_row[0]['user_email'];
            			$_SESSION['user_login_status'] = 1;
            	
            		} else {
            			$this->errors[] = "Wrong password. Try again.";
            		}
            	} else {
            		$this->errors[] = "This user does not exist.";
            	}
            }
            catch(PDOException $e)
            {
            	echo $e->getMessage();
            }
        
        }
    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}
