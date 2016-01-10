<?php
class db
{
	private $host;
	private $user;
	private $password;
	private $database;
	private $debug;
	private $sql;
	
	public $r;
	
	function __construct($sql)
    {
    	//set or import your cms's config
    	$conf = new Cms;
    
		$this->host = $conf->db['host'];
		$this->user = $conf->db['user'];
		$this->password = $conf->db['pass'];
		$this->database = $conf->db['name'];
		$this->debug = $conf->debug;
		
		//connect
		
		$this->sql = new mysqli($this->host, $this->user, $this->password, $this->database);
		
		if ($this->sql->connect_errno) 
		{
			if($this->debug)
			{
				echo "Error: Failed to make a MySQL connection, here is why: </br>\n";
				echo "Errno: \"" . $this->sql->connect_errno . "\"</br>\n";
				echo "Error: \"" . $this->sql->connect_error . "\"</br>\n";
				exit;
			}
			else
			{
				echo "Sorry, this website is experiencing problems.";
				exit;
			}
		}
		
		$this->query('SET NAMES utf8');
		$this->query($sql);
		
		//close
		
		$this->sql->close();
    }
	
	private function query($sql) 
	{
		if (!$this->r = $this->sql->query($sql)) 
		{
			if($this->debug)
			{
				echo "Error: Our query failed to execute and here is why: </br>\n";
				echo "Query: \"" . $sql . "\"</br>\n";
				echo "Errno: \"" . $this->sql->errno . "\"</br>\n";
				echo "Error: \"" . $this->sql->error . "\"</br>\n";
				exit;
			}
			else
			{
				echo "Sorry, the website is experiencing problems.";
				exit;
			}
		}
	}
}

//compatybility functions
function db_query($sql) //set your cms's function name using to query 
{
	return new db($sql);
}

function mysql_num_rows($db)
{
	return $db->r->num_rows;
}

function mysql_fetch_array($db)
{
	return $db->r->fetch_array();
}

function mysql_fetch_assoc($db)
{
	return $db->r->fetch_assoc();
}
?>
