<?php

class DB
{

    protected static $instance = null;
    protected $pdo;

    protected $table;
    protected $fields = '*';
    protected $wheres = [];

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
        $stmt->execute();
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


}