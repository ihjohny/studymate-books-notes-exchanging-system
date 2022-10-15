<?php

class DbData
{
	public $project_title = 'Books, Notes Sharing Platform For NSTU';
	public $email_verify = 0;
	public $base_url = 'http://localhost/';
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

	function executeWithReturn($data = null)
	{
		$this->statement = $this->connect->prepare($this->query);
		if ($data) {
			$this->statement->execute($data);
		} else {
			$this->statement->execute();
		}
		return $this->connect->lastInsertId();
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

	function is_admin_login()
	{
		if (isset($_SESSION['admin_id'])) {
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

	function isUserBlocked($user_id) {
		$isBlock = false;
		$this->query = "
		SELECT * FROM users
		WHERE id = '".$user_id."'
		";
		$data = $this->get_result();
		foreach($data as $row) {
			if($row['isBlock']){
				$isBlock = true;
			}
		}
		return $isBlock;
	}

	function typed($type) {
		if($type == 'Donate'){
			return 'Donated';
		} else {
			return "${type}ed";
		}
	}

}
