<?php

	namespace Integration;

	class Connection{

		private $connection = false;

		function __construct()
		{
			if($this->connection != false)
			{
				return $this->connection;
			}
			else
			{
				try
				{
					$this->connection = new \PDO('mysql:dbname=sablrcrm_test; host=50.87.144.13', 'sablrcrm_287f_cg',
						'W#(!8l=&%@Na');

					$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

					//$this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

					return $this->connection;
				}
				catch(\PDOException $ex)
				{
					return $ex->getMessage();
				}
			}
		}

		public function prepare($string){

			return $this->connection->prepare($string);
		}

		public function exec($string){

			return $this->connection->exec($string);
		}

		public function query(\PDOStatement $pdoStatement){

			return $this->connection->query($pdoStatement);
		}

		public function getSingleRecord(\PDOStatement $sql){

			$result = false;

			if($sql->rowCount() > 0){

				$rows = $sql->fetchAll(\PDO::FETCH_OBJ);

				$result = array_shift($rows);
			}
			return $result;
		}
	}