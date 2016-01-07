<?php
namespace config\anywheredb;

class AnywhereDB
{
    var $configurations = array();
    var $connections = null;
    var $statement = null;
    var $affectedRows = 0, $numRows = 0;

    function Database($configurations = null)
    {
        if ($configurations != null) {
            $this->configurations = $configurations;
            $this->Connect();
        } else {
            echo 'database configurations may empty';
        }
    }

    function Connect()
    {
        if ($this->configurations['DATABASE_TYPE'] == 'mysql') {
            $this->connections = @mysql_connect($this->configurations['HOSTNAME'], $this->configurations['USERNAME'],
                $this->configurations['PASSWORD']);

            if (!$this->connections && $this->configurations['DISPLAY_ERROR']) {
                echo mysql_errno($this->connections) . " : " . @mysql_error($this->connections);
                if ($this->configurations['BREAK_PROCESS']) exit(0);
            }

            $dbStatus = @mysql_select_db($this->configurations['DATABASE_NAME'], $this->connections);
            if (!$dbStatus && $this->configurations['DISPLAY_ERROR']) {
                echo @mysql_errno($this->connections) . " : " . @mysql_error($this->connections);
                if ($this->configurations['BREAK_PROCESS']) exit(0);
            }

        } else if ($this->configurations['DATABASE_TYPE'] == 'oracle') {
            echo 'not supported yet';
        }
    }

    function ExecuteQuery($query)
    {
        if ($this->configurations['DATABASE_TYPE'] == "mysql") {
            $this->statement = @mysql_query($query, $this->connections);
            $this->numRows = @mysql_num_rows($this->statement);
            $this->affectedRows = @mysql_affected_rows($this->statement);

            if (!$this->statement && $this->configurations['DISPLAY_ERROR']) {
                echo "query : " . $query . "\n";
                echo @mysql_errno($this->connections) . " : " . @mysql_error($this->connections);
                if ($this->configurations['BREAK_PROCESS']) exit(0);
            }
        }
        return $this->statement;
    }

    function FetchArray($query = null)
    {
        $statement = ($query != null) ? $query : $this->statement;
        $result = null;
        if ($this->configurations['DATABASE_TYPE'] == "mysql") {
            $result = @mysql_fetch_assoc($statement);
        }
        return $result;
    }

    function Insert($tablename, $arrayData)
    {
        $fields = array();
        $values = array();
        foreach ($arrayData as $key => $val) {
            $fields[] = ($key);
            $values[] = "$val";
        }
        $query = "INSERT INTO " . $tablename . " (" . @implode(', ', $fields) . ") VALUES (" . @implode(', ', $values) . ")";
        return $this->ExecuteQuery($query);
    }

    function Update($tablename, $arrayData, $condition = "")
    {

        $columns = array();
        foreach ($arrayData as $key => $val) {
            $columns[] = "$key=$val";
        }
        $sqlQuery = "UPDATE " . $tablename . " SET " . @implode(', ', $columns) . " " . ($condition ? " WHERE $condition" : "");
        return $this->ExecuteQuery($sqlQuery);
    }

    function Delete($tablename, $condition = "")
    {
        $sqlQuery = "DELETE FROM " . $tablename . ($condition ? " WHERE $condition" : "");
        return $this->ExecuteQuery($sqlQuery);
    }

    function Select($tablename, $fields = "*", $condition = "", $ordering = "")
    {
        $listFields = "*";
        $orderColumn = "";

        if (@is_array($fields)) {
            if (@count($fields) > 1) {
                $listFields = @implode(",", $fields);
            } elseif (@count($fields) == 1) {
                $listFields = $fields[0];
            }
        }

        if (@is_array($ordering)) {
            if (@count($ordering) > 1) {
                $orderColumn = @implode(",", $ordering);
            } elseif (@count($ordering) == 1) {
                $orderColumn = $ordering[0];
            }
        }

        $sqlQuery = "SELECT $listFields FROM ($tablename) " . (($condition != "") ? " WHERE " . $condition : "") . (($orderColumn != "") ? " ORDER BY " . $orderColumn : "");
        $statement = $this->ExecuteQuery($sqlQuery);

        if ($this->config['DB_TYPE'] == "mysql") {
            return $statement;
        } else {
            return false;
        }
    }

    function ReadRow($statement = null)
    {
        $count = 0;
        $arrData = null;
        if ($statement != null) {
            while ($row = $this->FetchArray($statement)) {
                $vArr = null;
                foreach ($row as $key => $val) {
                    $vArr[$key] = $val;
                }
                $arrData[] = $vArr;
                $count++;
            }
        } else {
            while ($row = $this->FetchArray()) {
                $vArr = null;
                foreach ($row as $key => $val) {
                    $vArr[$key] = $val;
                }
                $arrData[] = $vArr;
                $count++;
            }
        }
        $this->numRows = $count;
        return $arrData;
    }

    function SelectLimit($table, $start = 1, $end = 0)
    {
        $query = "select * from(select a.*,row_number()over(order by rownum)rnum from ($table) a) where rnum <=" . intval($end) . " and rnum >= " . intval($start);
        $statement = $this->ExecuteQuery($query);
        return $this->ReadRow($statement);
    }

    function GetTotalRow($dtIndex = "*", $sTable = "")
    {
        $query = "SELECT COUNT(" . ($dtIndex == "*" ? "*" : "a." . $dtIndex) . ") FROM ($sTable) a";
        $resultAll = $this->ExecuteQuery($query);
        $raData = $this->FetchArray($resultAll);
        $totalRecord = $raData[0];
        return $totalRecord;
    }

    function GetMaximumValue($columnName, $table)
    {
        $query = "SELECT MAX(" . $columnName . ") FROM ($table)";
        $resultAll = $this->ExecuteQuery($query);
        $raData = $this->FetchArray($resultAll);
        $maxValue = $raData[0];
        return $maxValue;
    }

    function SetAffectedRows($affRows)
    {
        $this->affectedRows = $affRows;
    }

    function GetNumRows()
    {
        return $this->numRows;
    }

    function GetAffectedRows()
    {
        return $this->affectedRows;
    }

    function getConnection()
    {
        return $this->connections;
    }

    function getStatement()
    {
        return $this->statement;
    }

    function GetConfiguration()
    {
        return $this->configurations;
    }
}


?>
