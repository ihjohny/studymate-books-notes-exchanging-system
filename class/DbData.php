<?php

class DbData
{
	public $connect;
	public $query;
	public $statement;

	public function __construct()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=studymate", "root", "");

		session_start();
	}

	function execute($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if ($data) {
			$this->statement->execute($data);
		} else {
			$this->statement->execute();
		}
	}

	function row_count()
	{
		return $this->statement->rowCount();
	}

	function statement_result()
	{
		return $this->statement->fetchAll();
	}

	function get_result()
	{
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function is_login()
	{
		if (isset($_SESSION['user_id'])) {
			return true;
		}
		return false;
	}

	function clean_input($string)
	{
		$string = trim($string);
		$string = stripslashes($string);
		$string = htmlspecialchars($string);
		return $string;
	}
}
