<?php

namespace prak5web\Models;

require "Config/Database.php";

use \prak5web\Config\Database;
use mysqli;

class Product extends Database
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function findAll()
    {
        $sql = "SELECT * FROM orders";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function findById($order_id)
{
    $sql = "SELECT products.*, orders.* FROM products
            JOIN orders ON products.id = orders.product_id
            WHERE orders.order_id = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $this->conn->close();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}



public function create($data)
{
    $productId = isset($data['product_id']) ? $data['product_id'] : null;
    $quantity = isset($data['quantity']) ? $data['quantity'] : null;
    $totalPrice = isset($data['total_price']) ? $data['total_price'] : null;

    // Periksa apakah data yang diperlukan ada atau tidak
    if ($productId !== null && $quantity !== null && $totalPrice !== null) {
        $query = "INSERT INTO orders (product_id, quantity, total_price) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $productId, $quantity, $totalPrice);
        $stmt->execute();
        $this->conn->close();
    } else {
        // Handle error jika data yang diperlukan tidak lengkap
        return false; // Atau throw exception sesuai kebutuhan
    }
}

public function update($data, $id)
{
    $productId = isset($data['product_id']) ? $data['product_id'] : null;
    $quantity = isset($data['quantity']) ? $data['quantity'] : null;
    $totalPrice = isset($data['total_price']) ? $data['total_price'] : null;

    $query = "UPDATE orders SET product_id = ?, quantity = ?, total_price = ? WHERE order_id = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("iiii", $productId, $quantity, $totalPrice, $id);
    $stmt->execute();
}


    public function destroy($id)
    {
        $query = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>
