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

}