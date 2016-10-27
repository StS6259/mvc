<?php
namespace core\models;

use core\models\RequestBuilder;

class ModelDb
{
    use RequestBuilder;

    public $result;
    protected $connection;

    function __construct()
    {
    }

    public function find($data)
    {
        if (is_integer($data)) {
            $where = 'id';
            $value = $data;
        } else {
            $where = key($data);
            $value = $data[$where];
        }
//        dd($where, $value);
        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE {$where} = '{$value}'";
        $this->connection = ConnectDb::getConnection();
        $request = $this->connection->prepare($sql);
        $request->execute();
        $row = $request->fetch(\PDO::FETCH_ASSOC);
        if ($row === false) {
            return null;
        }
        $this->result = $row;
        return $this;
    }

    public function all()
    {
        $this->connection = ConnectDb::getConnection();
        $request = $this->connection->prepare($this->getSqlRequest());
        if (count($this->arguments) !== 0) {
            foreach ($this->arguments as $key => $value) {
                $request->bindValue(':' . $key, $value);
            }
        }
        $request->execute();
        $rows = $request->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $this->result = $row;
            $result[] = clone $this;
        }
        return $result ?? [];
    }

    public function getSqlRequest()
    {
        if ($this->select === null) {
            $request = "SELECT * FROM " . $this->getTableName() . " ";
        } else {
            $request = $this->select;
            $request .= "FROM " . $this->getTableName() . " ";
        }
        if ($this->where !== null) {
            foreach ($this->where as $value) {
                $request .= $value;
            }
        }
        if ($this->orderby !== null) {
            $request .= $this->orderby;
        }
        return $request;

    }

    public function create(array $data)
    {
        $this->connection = ConnectDb::getConnection();
        $fields = array_keys($data);
        $sql = "INSERT INTO " . $this->getTableName() . ' (' . implode(',', $fields) .
            ') VALUES (' . implode(',', array_map(function ($item) {
                return "\"{$item}\"";//todo mysqli_real_escape_string
            },$data)) . ')';
        $request = $this->connection->prepare($sql);
        if ($request->execute()) {
            return $this->find(['email' => $data['email']]);
        }
        return null;
    }

}