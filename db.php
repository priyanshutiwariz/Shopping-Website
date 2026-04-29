<?php
// Database config - update these values for your host
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_pass');
define('DB_NAME', 'your_db_name');

// Attempt mysqli connection; if it fails, provide a safe stub so pages still render locally
mysqli_report(MYSQLI_REPORT_OFF);
@$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    // lightweight stubs to avoid fatal errors when no DB is configured
    class DummyResult {
        public function fetch_assoc() { return false; }
        public function fetch_all($mode = MYSQLI_ASSOC) { return []; }
        public function num_rows() { return 0; }
    }
    class DummyStmt {
        public function bind_param() { return true; }
        public function execute() { return false; }
        public function get_result() { return new DummyResult(); }
        public function close() { return true; }
    }
    class DummyMysqli {
        public function query($q) { return new DummyResult(); }
        public function prepare($q) { return new DummyStmt(); }
        public function real_escape_string($s) { return addslashes($s); }
        public function close() {}
    }
    $mysqli = new DummyMysqli();
}

// Start session for auth/cart
if (session_status() === PHP_SESSION_NONE) session_start();

?>
