<?php

class Category
{
    // table name definition and database connection
    private $db_conn;
    private $table_name = "categories";

    // object properties
    public $id;
    public $name;

    public function __construct($db)
    {
        $this->db_conn = $db;
    }

    // used by create.php and edit.php to select category drop-down list
    function getAll()
    {
        //select all data
        $sql = "SELECT id, name FROM " . $this->table_name . "  ORDER BY name";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->execute();

        return $prep_state;
    }

    // used by index.php to read category name
    function getName()
    {

        $sql = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

        $prep_state = $this->db_conn->prepare($sql);
        $prep_state->bindParam(1, $this->id); // und somit der Platzhalter der SQL Anweisung :id durch die angegebene Variable $id ersetzt.
        $prep_state->execute();

        $row = $prep_state->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
    }
}

