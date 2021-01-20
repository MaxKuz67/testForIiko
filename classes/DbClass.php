<?php
	class Db
	{
		private $link;
		public $current_sql;

		public $BD;

		public $HOST;

		public $LOGIN;

		public $PASSWORD;
			
		public function __construct($HOST, $LOGIN, $PASSWORD, $BD)
		{
			$this->BD = $BD;
			$this->HOST = $HOST;
			$this->LOGIN = $LOGIN;
			$this->PASSWORD = $PASSWORD;

			$this->link = mysqli_connect($HOST, $LOGIN, $PASSWORD, $BD);
			$this->link->set_charset("utf8");
			
		}
		
		public function insert($table, $cols_ar)
		{
			$cols = [];
			$vals = [];
			foreach ($cols_ar as $col => $val)
			{
				$cols[] = "`".$col."`";
				$vals[] = '"'.$this->real_escape_string($val).'"';
			}
			$query = $this->query("INSERT INTO ".$table." (".implode(",",$cols).")VALUES(".implode(",",$vals).")");
			if (!$query)
			{
				return false;
			}
			else
			{
				return $this->insert_id();
			}
		}
		
				
		public function query($sql)
		{
			$this->current_sql = $sql;
			$query = mysqli_query($this->link, $sql);
			if (!$query)
			{
				throw new Exception(mysqli_error($this->link)."\r\n".$sql);
			}
			
			return $query;
		}
			
		public function real_escape_string($string)
		{
			return mysqli_real_escape_string($this->link, $string);
		}
		
				
		public function insert_id()
		{
			return mysqli_insert_id($this->link);
		}
			
		public function num_rows($query)
		{
			if ($query)
			{
				return mysqli_num_rows($query);
			}
			else
			{
				throw new Exception(
					"Произошла ошибка при выполнении SQL запроса: \r\n".
					$this->error().
					": ".
					$this->current_sql);
			}
		}
		
		public function fetch($query)
		{
			$a = [];
			while ($row = mysqli_fetch_assoc($query))
			{
				$a[] = $row;
			}
			return $a;
		}

		public function fetch_object($query)
		{
			$a = [];
			while ($row = mysqli_fetch_object($query))
			{
				$a[] = $row;
			}
			return $a;
		}

		public function one($query)
		{
			$a = $this->fetch($query);
			
			if(count($a) > 0)
			{
				return $a[0];
			}
			return [];
		}
		
		public function error()
		{
			return mysqli_error($this->link);
		}
					
		public function update($table, $rows, $id, $col = "id")
		{
			$r = [];
			foreach ($rows as $key => $val)
			{
				$r[] = '`'.$key.'` = "'.$this->real_escape_string($val).'"';
			}
			$sql = 'UPDATE '.$table.' SET '.implode(", ", $r).' WHERE `'.$col.'` = "'.$this->real_escape_string($id).'"';
			$this->query($sql);
		}

		public function delete_row($table, $id, $col = "id")
		{
			$where = "";
			if (is_array($id))
			{
				foreach ($id as $key => $val)
				{
					$id[$key] = '"'.$this->real_escape_string($val).'"';
				}
				$where = "IN (".implode(',', $id).")";
			}
			else
			{
				$where = ' = "'.$this->real_escape_string($id).'"';
			}
			$sql = "DELETE FROM ".$table." WHERE ".$col." ".$where;
			$this->query($sql);
		}

		
	}
?>