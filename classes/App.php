<?php

class App {
    private $db;

    public function __construct() {
        session_start();
        $dbhost = "127.0.0.1";
		$dbuser = "root";
		$dbpassword = "";
		$dbname = "web_project";

        $connection = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
        //Test if connection occoured
		if($connection->connect_errno){
			die("DB connection failed: " . $connection->connect_error . " (" . $connection->connect_errno . ")");
		}

		if (!$connection){
            die('Could not connect: ' . $connection->error);
        }

        $this->db = $connection;
    }

    public function login($payload) {
        $email = $payload['email'];
        $password = $payload['password'];

        $stmt = $this->db->prepare("SELECT email, name FROM user WHERE email = ? AND password = MD5(?)");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        return $row;
    }

    public function products() {
        $products = $this->db->query("SELECT * FROM products");
        return $products->fetch_all(MYSQLI_ASSOC);
    }

    public function addProduct($id) {
        $product = $this->db->query("SELECT * FROM products");
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        if (!empty($row)) {
            $products = $_SESSION['products'];
            if (!empty($products)) {
                $products[] = $product;
            } else {
                $_SESSION['products'] = array($product);
            }

            return true;
        }

        return false;
    }
}