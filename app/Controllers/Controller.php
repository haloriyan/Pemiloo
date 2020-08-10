<?php

include '../app/Framework/DB.php';
include '../app/Framework/Curl.php';
include '../app/Framework/Mailer.php';
include '../app/Framework/Session.php';
include '../app/Framework/Storage.php';

class Controller {
	private static $_instance = null;

    public function get($index = NULL) {
		global $query,$type,$name;
		if ($query == "") {
			if ($type == "cookie") {
				return $_COOKIE[$name];
			}else if ($type == "session") {
				// 
			}
			return $type;
		}
	}

	public function session($nama) {
		global $type,$name;
		@session_start();
		$type = "session";
		$name = $nama;

		if(self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
	}
	public function cookie($nama) {
		global $type,$name;
		$type = "cookie";
		$name = $nama;

		if(self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
	}
	public function set($value) {
		global $type,$name;
		if ($type == "cookie") {
			setcookie($name, $value, time() + 3600, "/");
		}else if ($type == "session") {
			// 
		}
	}
	public function unset() {
		global $type,$name;
		if ($type == "cookie") {
			setcookie($name, '', time() + 1, "/");
		}else if ($type == "session") {
			// 
		}
	}

	public function middleware($name, $except = NULL) {
		$path = "../app/Middleware/".$name.".php";
		if (file_exists($path)) {
			include $path;
			$$name = new $name();
			if ($except != "") {
				global $method;
				$queue = [];
				foreach ($except as $key => $x) {
					if ($x == $method) {
						break;
					}else {
						array_push($queue, $key);
					}
				}
				if (count($except) == count($queue)) {
					$$name->handle();
				}
			}else{
				$$name->handle();
			}
		}else {
			die("Middleware not found");
		}
		if(self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
	}

	public function migrate() {
		$migration = file_get_contents("./migration.json");
		$db = json_decode($migration, true);

		foreach ($db['table'] as $key => $value) {
			$tableName = $key;
			$queryTable = "CREATE TABLE ".$tableName." (";
			foreach ($value as $q => $val) {
				$a = explode(" ", $val);
				$struktur = $a[0];
				$tipe = $a[1];
				$isNull = $a[2] == "" ? "null" : "not null";
				$queryTable .= $struktur." ".$tipe." ".$isNull.", ";
			}
			$queryTable .= " dummy int(1) not null);";
			$this->query($queryTable);
			$delDummy = $this->query("ALTER TABLE {$tableName} DROP dummy");
			echo "Table {$tableName} created <br />";
		}

		foreach ($db['attribute'] as $key => $value) {
			foreach ($value as $kunci => $isi) {
				$t = explode(".", $isi);
				
				$queryAttribute = "ALTER TABLE ".$t[0]." ADD ".$key." KEY ";
				if (strtolower($key) != "foreign") {
					$queryAttribute .= "({$t[1]})";
				}
				if (strtolower($key) == "foreign") {
					$f = explode("=>", $isi);
					$ta[0] = explode(".", $f[0]);
					$ta[1] = explode(".", $f[1]);
					$queryAttribute .= "({$ta[0][1]}) REFERENCES {$ta[1][0]}({$ta[1][1]})";
				}
				$addingAttribute = $this->query($queryAttribute);
				echo "Table {$t[0]} changed : {$queryAttribute} <br />";

				// add auto_increment
				if ($addingAttribute) {
					if (strtolower($key) == "primary") {
						$queryAi = "ALTER TABLE {$t[0]} MODIFY {$t[1]} INTEGER NOT NULL AUTO_INCREMENT";
						$this->query($queryAi);
						echo "Table {$t[0]} added auto increment on {$t[1]} : {$queryAi}<br />";
					}
				}
			}
		}
	}
}

$Controller = new Controller();