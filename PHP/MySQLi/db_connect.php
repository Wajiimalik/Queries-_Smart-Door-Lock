
<?php
class DB_CONNECT {

    public $connection;

    // constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

    function connect() {
        // import database connection variables
        require_once __DIR__ . '/db_config.php';

        // Connecting to mysql database
        $con = @mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysqli_error("Failed at connection"));

        // Selecing database
        $db = mysqli_select_db($con, DB_DATABASE) or die(mysqli_error("Failed at selecting db"));

        // returing connection cursor
        $this->connection = $con;
    }

    function close() {
        // closing db connection
        mysqli_close($this->connection);
    }

}
