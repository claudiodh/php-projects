<?php

namespace src\Repositories;

use PDO;
use PDOException;

class Repository {

	protected PDO $pdo;
	private string $hostname;
	private string $username;
	private string $databaseName;
	private string $databasePassword;
	private string $charset;

	public function __construct() {
		// Note: in a real application we'd want to use environment variables to store credentials and any other environment specific data.
		// If you're interested in how to do this, look into: https://github.com/vlucas/phpdotenv
		// If you know about PHP frameworks, DotEnv is what Laravel uses for this purpose
		$this->hostname = 'localhost';
		$this->username = 'root';
		$this->databaseName = 'article_aggregator_co';
		$this->databasePassword = 'totodile';
		$this->charset = 'utf8mb4';

		$dsn = "mysql:host=$this->hostname;dbname=$this->databaseName;charset=$this->charset";
		// For options info, see: https://www.php.net/manual/en/pdo.setattribute.php
		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];
		try {
			$this->pdo = new PDO($dsn, $this->username, $this->databasePassword, $options);
		} catch (PDOException $e) {
			throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	}

}
