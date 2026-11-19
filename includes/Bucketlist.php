<?php

class Bucketlist
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Hämta alla saker från bucketlistan
    public function getAllItems()
    {
        $sql = "SELECT * FROM items ORDER BY priority ASC";
        $result = $this->db->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lägg till en ny sak
    public function addItem($name, $description, $priority)
    {
        $sql = "INSERT INTO items (name, description, priority) VALUES (?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssi", $name, $description, $priority);

        return $stmt->execute();
    }

    // Radera en sak
    public function deleteItem($id)
    {
        $sql = "DELETE FROM items WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>