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

    /**
     * return one record from db
     * @param $data
     * @return $this|null
     */
    public function find($data)
    {
        if (is_numeric($data)) {
            $where = 'id';
            $value = $data;
        } else {
            $where = key($data);
            $value = $data[$where];
        }
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

    /**
     * execute sql
     * @return array
     */
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

    /**
     * insert record to table
     * @param array $data
     * @param string $key
     * @return ModelDb|null
     */
    public function create(array $data)
    {
        $fields = array_keys($data);
        $sql = "INSERT INTO " . $this->getTableName() . ' (' . implode(',', $fields) .
            ') VALUES (' . implode(',', array_map(function ($item) {
                return "\"" . trim($item) . "\"";
            },$data)) . ')';
        if ($this->execute($sql)) {
            return $this->getLastRecord();
        }
        return null;
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        $sql = 'UPDATE ' . $this->getTableName() . ' SET ';
        $count = 1;
        foreach ($data as $field => $value) {
            $sql .= ($count++ === 1) ? '' : ',';
            $sql .= "{$field} = \"" . trim($value) . "\"";
        }
        $sql .= " WHERE {$attribute} = \"$id\"";
        return $this->execute($sql);
    }

    protected function execute($sql)
    {
        $this->connection = ConnectDb::getConnection();
        $request = $this->connection->prepare($sql);
        return $request->execute();
    }

    protected function getLastRecord()
    {
        $sql = "SELECT * FROM " . $this->getTableName() . " ORDER BY ID DESC LIMIT 1";
        $this->connection = ConnectDb::getConnection();
        $request = $this->connection->prepare($sql);
        $request->execute();
        $row = $request->fetch(\PDO::FETCH_ASSOC);
        $this->result = $row;
        return $this;
    }

}