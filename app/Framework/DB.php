<?php

class DB {
    private static $_instance = null;
    
    public function __construct() {
		$this->koneksi();
	}
	
	public function koneksi() {
		/* You can edit this on /.env */
		global $dbHost,$dbUser,$dbPass,$dbName;
		$dbHost = env('DB_HOST');
        $dbUser = env('DB_USER');
        $dbPass = env('DB_PASS');
		$dbName = env('DB_NAME');
		
		$this->koneksi = new \mysqli($dbHost, $dbUser, $dbPass, $dbName);
	}
	
	/*
		This is a query builder. For usage, check the documentation
	*/
	public function checkWhereAvailable($query) {
        $p = explode("WHERE", $query);
		return $p[0] != "" ? false : true;
    }
    public function table($namaTabel) {
        global $query;
        global $tabel;
        $tabel = $namaTabel;

        if(self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }
    public function select() {
        global $query;
		global $tabel;
		$kolom = func_get_args();
		$printCol = "";
		if (count($kolom) == 1) {
			$printCol = $kolom[0];
		}
		if (count($kolom) == 0) {
			$printCol = "*";
		}

		if (count($kolom) > 1) {
			$i = 0;
			foreach ($kolom as $key => $kol) {
				$separator = $i++ < count($kolom) - 1 ? "," : "";
				$printCol .= "$kol".$separator;
			}
		}

        $query = "SELECT $printCol FROM $tabel";
        return $this;
    }
    public function innerJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " INNER JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return $this;
    }
    public function leftJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " LEFT JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return $this;
    }
    public function rightJoin($tabel, $firstFK, $operator, $secondFK) {
        global $query;
        $query .= " RIGHT JOIN ".$tabel." ON $firstFK ".$operator." $secondFK";
        return $this;
    }
    public function create($data) {
        global $query;
        global $tabel;

        $query = "INSERT INTO $tabel (";
        $i = 0;
        foreach($data as $key => $value) {
            $separator = ($i++ < count($data) - 1) ? ", " : "";
            $query .= "$key" . $separator;
        }
        $query .= ") VALUES (";

        $a = 0;
        foreach($data as $key => $value) {
            $separator = ($a++ < count($data) - 1) ? ", " : "";
            $query .= "'$value'" . $separator;
        }
        $query .= ")";

        return $this;
    }
    public function delete() {
		global $query,$tabel;
        $query  = "DELETE FROM $tabel";
        return $this;
    }

    public function where($filter, $operator = NULL, $value = NULL) {
        global $query;
        $adaWhere = $this->checkWhereAvailable($query);
		$query .= $adaWhere ? " AND" : " WHERE ";
        
        if(is_array($filter)) {
            $i = 0;
            $totalFilter = count($filter);
            foreach ($filter as $key => $value) {
				$separator = $i++ < $totalFilter - 1 ? " AND " : "";
                $query .= $value[0] . " " . $value[1] . " '" . $value[2] . "'" . $separator;
            }
        }else {
            $query .= " $filter $operator '$value'";
        }
        return $this;
    }
    public function between($kolom, $value) {
        global $query;
        $adaWhere = $this->checkWhereAvailable($query);
        if($adaWhere) {
            $query .= " AND $kolom BETWEEN '$value[0]' AND '$value[1]'";
        }else {
            $query .= " WHERE $kolom BETWEEN '$value[0]' AND '$value[1]'";
        }
        return $this;
    }
    public function limit($posisi, $batas = NULL) {
        global $query;
        if($batas == "") {
            $batas = $posisi;
            $query .= " LIMIT $batas";
        }else {
            $query .= " LIMIT $posisi,$batas";
        }
        return $this;
    }
    public function orderBy($kolom, $mode = NULL) {
        global $query;
        
        if(is_array($kolom)) {
            $query .= " ORDER BY ";
            $i = 0;
            $totalFilter = count($kolom);
            foreach ($kolom as $row) {
                $separator = ($i++ < $totalFilter - 1) ? ", " : "";
                $query .= "$row[0] $row[1]".$separator;
            }
        }else {
            $query .= " ORDER BY $kolom $mode";
        }
        return $this;
	}
	public function query($qry, $realQuery = NULL) {
		if ($realQuery != NULL) {
			$run = mysqli_query($qry, $realQuery);
			return $realQuery;
		}
		return mysqli_query($this->koneksi, $qry);
	}

    public function execute() {
        global $query;
        $res = mysqli_query($this->koneksi, $query);
        return $res;
    }

    public function update($data) {
        global $query;
        global $tabel;
        $query = "UPDATE $tabel SET ";
        $i = 0;
        foreach($data as $key => $value) {
            if (preg_match("/'/", $value)) {
                $quote = "'";
                $value = str_replace("'", "''", $value);
            }else if (preg_match('/"/', $value)) {
                $quote = '"';
                $value = str_replace('"', '""', $value);
            }else {
                $quote = "'";
            }
			$separator = $i++ < count($data) - 1 ? ", " : "";
            $query .= "$key = $quote$value$quote" . $separator;
        }
        return $this;
    }
    public function toSql() {
		global $query;
		return $query;
	}
    public function first() {
        global $query;
        $runQuery = mysqli_query($this->koneksi, $query);
		$data = mysqli_fetch_assoc($runQuery);
		if (!$data) return false;
		$query = "";
		return $this->toObject($data);
	}
	public function toObject($datas) {
		return json_decode(json_encode($datas), FALSE);
    }
    public function get() {
        global $query;
        $runQuery = mysqli_query($this->koneksi, $query);
		$res = [];
        while($data = mysqli_fetch_assoc($runQuery)) {
            $res[] = $data;
		}
		$query = "";
        return $this->toObject($res);
    }
}
