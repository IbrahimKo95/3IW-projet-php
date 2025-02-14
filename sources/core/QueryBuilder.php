<?php

class DB
{

    protected static $instance = null;
    protected $pdo;

    protected $table;
    protected $fields = '*';
    protected $wheres = [];

    protected $joins = [];

    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=mariadb;dbname=database', 'user', 'password', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function __clone() {}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function table ($table)
    {
        $instance = self::getInstance();
        $instance->table = $table;
        return $instance;
    }

    public function select($fields)
    {
        $this->fields = $fields;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $this->wheres[] = [
            'type' => 'OR',
            'column' => $column,
            'operator' => $operator,
            'value' => $value
        ];
        return $this;
    }


    public function get()
    {
        $sql = 'SELECT ' . $this->fields . ' FROM ' . $this->table;

        if (!empty($this->joins)) {
            foreach ($this->joins as $join) {
                $sql .= ' INNER JOIN ' . $join['table'] . ' ON ' . $join['firstColumn'] . ' ' . $join['operator'] . ' ' . $join['secondColumn'];
            }
        }

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ';
            $conditions = [];
            foreach ($this->wheres as $index => $where) {
                $conditions[] = "{$where['column']} {$where['operator']} ?";
            }
            $sql .= implode(' ', array_map(fn($w, $i) => ($i > 0 ? $this->wheres[$i]['type'] . ' ' : '') . $w, $conditions, array_keys($conditions)));
        }


        $stmt = $this->pdo->prepare($sql);
        $bindedValues = array_column($this->wheres, 'value');
        foreach ($bindedValues as $index => $value) {
            $stmt->bindValue($index + 1, $value);
        }
        $stmt->execute();
        $this->wheres = [];
        $this->joins = [];
        $this->table = null;
        $this->fields = '*';
        return $stmt->fetchAll();
    }


    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_values($data));

        return $this->pdo->lastInsertId();
    }

    public function update(array $data, $id)
{
    $setClause = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));

    $sql = "UPDATE $this->table SET $setClause WHERE id = ?";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute(array_merge(array_values($data), [$id]));

    return $stmt->rowCount();
}

    public function insertPerso(array $data, $spe = null)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($col) => ":$col", array_keys($data)));

        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        foreach ($data as $key => $item) {
            $name = ":" . $key;
            $thirdParam = isset($spe[$name]) ? $spe[$name] : PDO::PARAM_STR;

            $stmt->bindParam($name, $data[$key], $thirdParam);
        }
        $stmt->execute();

        return $this->pdo->lastInsertId();
    }

    public function delete()
    {
        $sql = "DELETE FROM $this->table";

        if (!empty($this->wheres)) {
            $sql .= ' WHERE ';
            foreach ($this->wheres as $index => $where) {
                if ($index > 0) {
                    $sql .= $where['type'] . ' ';
                }
                $sql .= $where['column'] . ' ' . $where['operator'] . ' ?';
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $bindedValues = array_column($this->wheres, 'value');
        $stmt->execute($bindedValues);

        return $stmt->rowCount();
    }

    public function join($table, $firstColumn, $operator, $secondColumn)
    {
        $this->joins[] = [
            'table' => $table,
            'firstColumn' => $firstColumn,
            'operator' => $operator,
            'secondColumn' => $secondColumn
        ];
        return $this;
    }


}