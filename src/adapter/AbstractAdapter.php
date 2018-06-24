<?php
/**
 * Created by PhpStorm.
 * User: kaptan
 * Date: 17.07.2017
 * Time: 15:13
 */

namespace src\adapter;

define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'blog');

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * @var \mysqli
     */
    protected $conn;

    protected $sql;

    /**
     * @var \mysqli_result
     */
    protected $result;


    public function __construct()
    {
        $this->conn = new \mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        // bağlantı kontrolünü sağladık
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insert($entity)
    {
        $entityMethods = get_class_methods($entity);
        $className = str_replace("src\\entity\\", "", get_class($entity));
        foreach ($entityMethods as $entityMethod) {
            if (substr($entityMethod, 0, 3) == "get") {
                $value = $entity->{$entityMethod}();
                if ($value != null) {
                    $key = lcfirst(str_replace("get", "", $entityMethod));
                    $keyList[] = $key;
                    $valueList[] = $value;
                }
            }
        }
        $keyQuery = implode(",", $keyList);
        $valueList = array_map([$this, "addQuotes"], $valueList);
        $valueQuery = implode(",", $valueList);
        $sqlParts = [
            "INSERT INTO " . $className . "(",
            $keyQuery . ") ",
            "VALUES(",
            $valueQuery . ");"
        ];
        $this->sql = implode("", $sqlParts);

    }


    public function select($tableName, $params = null)
    {
        $whereQuery = "";
        $selectQuery = "SELECT * FROM " . $tableName;
        if ($params == null) {
            $this->sql = $selectQuery;
            return;
        }
        if (isset($params["where"])) {
            $whereParams = $params["where"];
            $whereValueQuery = "";
            if (isset($whereParams["and"])) {
                $andParams = $whereParams["and"];
                $andQueryParams = [];
                foreach ($andParams as $key => $andParam) {
                    $andQueryParams[] = $key . "=" . $this->addQuotes($andParam);
                }
                $whereValueQuery = implode(" AND ", $andQueryParams);
            } elseif (isset($whereParams["or"])) {
                $orParams = $whereParams["or"];
                $orQueryParams = [];
                foreach ($orParams as $key => $orParam) {
                    $orQueryParams[] = $key . "=" . $this->addQuotes($orParam);
                }
                $whereValueQuery = implode(" OR ", $orQueryParams);
            } else {

                $defaultQueryParams = [];
                foreach ($whereParams as $key => $orParam) {
                    $defaultQueryParams[] = $key . "=" . $this->addQuotes($orParam);
                }
                $whereValueQuery = implode("", $defaultQueryParams);
            }

            $whereQuery = "WHERE " . $whereValueQuery;
        }
        if ($whereQuery != "") {
            $this->sql = $selectQuery . " " . $whereQuery;
        }
    }

    public function update($entity, $params)
    {
        $entityMethods = get_class_methods($entity);
        $className = str_replace("src\\entity\\", "", get_class($entity));
        if (in_array("getId", $entityMethods)) {
            $entityId = $entity->getId();
            foreach ($params as $key => $value) {
                $setQueryParams[] = $key . "='" . $value . "'";
            }
            $setQuery = implode(",", $setQueryParams);
            if ($setQuery != "") {
                $setQuery = "SET " . $setQuery;
            }
            $whereQuery = " WHERE id='" . $entityId . "'";
            $entityQuery = "UPDATE " . $className . " ";
            $updateQuery = $entityQuery . $setQuery . $whereQuery;
            $this->sql = $updateQuery;
            return true;
        }
        return false;
    }


    public function delete($entity)
    {
        $entityMethods = get_class_methods($entity);
        $className = str_replace("src\\entity\\", "", get_class($entity));
        if (in_array("getId", $entityMethods)) {
            $entityId = $entity->getId();
            $whereQuery = " WHERE id='" . $entityId . "'";
            $entityQuery = "DELETE FROM " . $className;
            $deleteQuery = $entityQuery . $whereQuery;
            $this->sql = $deleteQuery;
            return true;
        }
        return false;
    }

    public function execute()
    {

        $this->result = $this->getConn()->query($this->sql);
    }

    /**
     * @return \mysqli
     */
    public function getConn()
    {
        return $this->conn;
    }

    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @return \mysqli_result
     */
    public function getResult()
    {
        return $this->result;
    }


    protected function addQuotes($str)
    {
        return "'$str'";
    }

    public function logOut()
    {
        session_unset();
        session_destroy();

    }

}


