<?php

class Database
{
    private SQLite3 $db;

    public function __construct(string $filename)
    {
        $this->db = new SQLite3($filename);
    }

    public function initialaze(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS task
                    (
                        id INTEGER NOT NULL, 
                        done BOOLEAN NOT NULL,
                        name VARCHAR(255) NOT NULL,
                        date DATETIME DEFAULT (datetime('now', 'localtime')),
                        PRIMARY KEY('id' AUTOINCREMENT)
                    );";
        $this->exec($query);
    }

    public function getTasks(): array
    {
        $tasks = [];

        $query = "SELECT * FROM task ORDER BY date DESC";

        $data = $this->db->query($query);

        while ($row = $data->fetchArray()) {
            $tasks[] = $row;
        }

        return $tasks;
    }

    public function addTask(string $name): void
    {
        $query = "INSERT INTO task (`done`, `name`, `date`) 
                    VALUES (false, '$name', datetime('now', 'localtime'));";
        $this->exec($query);
    }

    public function updateTask(int $id, int $done)
    {
        $query = "UPDATE task SET `done` = $done WHERE `id` = $id";

        $this->exec($query);
    }

    public function modifyTask(int $id, string $newTaskName): void
    {
        $query = "UPDATE task SET `name` = '$newTaskName' WHERE `id` = $id";

        $this->exec($query);
    }

    public function deleteTask(int $id): void
    {
        $query = "DELETE FROM task WHERE `id` = $id";

        $this->exec($query);
    }
    
    public function getDatabase(): SQLite3
    {
        return $this->db;
    }

    private function exec(string $query): void
    {
        $this->db->prepare($query);
        $this->db->exec($query);
    }
}