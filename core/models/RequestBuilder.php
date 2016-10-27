<?php

namespace core\models;

trait RequestBuilder
{
    protected $maxCountSameKey = 5;
    protected $valid_params = ['>=', '!=', '<=', '=', '>', '<'];

    protected $select;
    protected $where;
    protected $orderby;
    protected $arguments;

    public function select($params)
    {
        if (is_array($params)) {
            $this->select = "SELECT " . implode(", ", $params) . " ";
        } else {
            $this->select = "SELECT " . $params . " ";
        }
        return $this;
    }

    public function whereBetween(...$params)
    {
        if (count($params) === 3) {
            $this->addWhereClose("AND", [$params[0], 'between', $params[1], $params[2]]);
            return $this;
        } else {
            throw new \Exception('Wrong number of parameters in whereBetween condition!');
        }
    }

    public function orwhere(...$params)
    {
        $this->addWhereClose("OR", $params);
        return $this;
    }

    public function getNewArgumentName($key, $value)
    {
        if (!isset($this->arguments[$key])) {
            $this->arguments[$key] = $value;
            return $key;
        }
        for ($i = 2; $i < $this->maxCountSameKey; $i++) {
            $newArgument = $key . $i;
            if (array_key_exists($newArgument, $this->arguments) === false) {
                $this->arguments[$newArgument] = $value;
                return $newArgument;
            }
        }
        throw new \Exception("To many conditions for the same column!");
    }

    public function addWhereClose($condition, $params)
    {
        if (empty($this->where)) {
            $where = "WHERE ";
        } elseif ($condition === "OR") {
            $where = "OR ";
        } else {
            $where = "AND ";
        }
        $numberOfParams = count($params);
        switch ($numberOfParams) {
            case 1: {
                if (is_array($params[0])) {
                    foreach ($params[0] as $key => $value) {
                        $where .= "$key = :"
                            . $this->getNewArgumentName($key, $value) . " AND ";
                    }
                    $where = substr_replace($where, '', -4);
                } else {
                    throw new \Exception("Wrong arguments in \"Where\" close.");
                }
                break;
            }
            case 2 : {
                $where .= "$params[0] = :"
                    . $this->getNewArgumentName($params[0], $params[1]) . " ";
                break;
            }
            case 3 : {
                if (in_array($params[1], $this->valid_params)) {
                    $where .= "$params[0] $params[1] :"
                        . $this->getNewArgumentName($params[0], $params[2]) . " ";
                } else {
                    throw new \Exception("Wrong comparison sign!");
                }
                break;
            }
            case 4 : {
                if (trim($params[1]) === 'between') {
                    $where .= "$params[0] BETWEEN :" .
                        $this->getNewArgumentName($params[0], $params[2]) . " AND :" .
                        $this->getNewArgumentName($params[0], $params[3]) . " ";
                } else {
                    throw new \Exception("Wrong comparison sign in between condition!");
                }
                break;
            }
        }
        $this->where[] = $where;
    }

    public function where(...$params)
    {
        $this->addWhereClose("AND", $params);
        return $this;
    }

    public function getTableName()
    {
        $path = explode("\\", strtolower(get_class($this)));
        return str_replace('model', '', $path[count($path) - 1]);
    }

    public function orderBy($columns, $direction = "ASC")
    {
        if (strtoupper($direction) === "ASC" || strtoupper($direction) === "DESC") {
            if (is_array($columns)) {
                if (count($columns) === 1) {
                    $this->orderby = "ORDER BY " . $columns[0] . " " . $direction;
                }
                $this->orderby = "ORDER BY " . implode(", ", $columns) . " " . $direction;
            } else {
                $this->orderby = "ORDER BY " . $columns . " " . $direction;
            }
        } else {
            throw new \Exception("Wrong order direction!");
        }
        return $this;
    }

    public function OrWhereBetween(...$params)
    {
        $this->orwhere($params[0], 'between', $params[1], $params[2]);
    }

    public function __call($name, $arguments)
    {
        $lowerNames = str_replace('where', '', strtolower($name));
        $numberOfArguments = count($arguments);
            $columns = explode("and", $lowerNames);
            $conditionNumber = count($columns);
            if ($conditionNumber === $numberOfArguments) {
                foreach ($columns as $key => $value) {
                    $condition[$value] = $arguments[$key];
                }
                $this->where($condition);
            } else {
                throw new \Exception("Wrong number of arguments in \"Where\" condition!");
            }
        return $this;
    }

}