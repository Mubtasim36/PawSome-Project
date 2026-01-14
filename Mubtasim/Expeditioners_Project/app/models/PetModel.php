<?php
require_once dirname(__DIR__) . '/config/database.php';

class PetModel
{
    private mysqli $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        // TEMP DEBUG (remove after confirm):
        // $r = $this->conn->query("SELECT DATABASE() AS db");
        // echo "Connected DB = " . ($r ? $r->fetch_assoc()['db'] : 'UNKNOWN');
        // exit;
    }

    public function getAllForBrowse(): array
    {
        $sql = "SELECT pet_id, name, species, breed, age_years, gender, location
                FROM pets
                ORDER BY pet_id DESC";

        $result = $this->conn->query($sql);

        // DO NOT silently return []
        if (!$result) {
            die("SQL Error: " . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}