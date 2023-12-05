<?php

namespace prak5web\Controllers;

require "Traits/ApiResponseFormatter.php";
require "Models/Product.php";

use \prak5web\Models\Product;
use \prak5web\Traits\ApiResponseFormatter;

class ProductController
{
    use ApiResponseFormatter;

    public function index()
    {
        $productModel = new Product();
        $response = $productModel->findAll();
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($order_id)
    {
        $productModel = new Product();
        $response = $productModel->findById($order_id);
        return $this->apiResponse(200, "success", $response);
    }

    public function insert()
{
    $jsonInput = file_get_contents('php://input');
    $inputData = json_decode($jsonInput, true);

    if (json_last_error()) {
        return $this->apiResponse(400, "error invalid input", null);
    }

    $orderModel = new Product();  // Ganti dengan instansiasi model order
    $response = $orderModel->create([
        "product_id" => $inputData['product_id'],
        "quantity" => $inputData['quantity'],
        "total_price" => $inputData['total_price']
    ]);

    return $this->apiResponse(200, "success", $response);
}


public function update($id)
{
    $jsonInput = file_get_contents('php://input');
    $inputData = json_decode($jsonInput, true);

    if (json_last_error()) {
        return $this->apiResponse(400, "error invalid input", null);
    }

    $productModel = new Product();
    $response = $productModel->update($inputData, $id);

    return $this->apiResponse(200, "success", $response);
}


    public function delete($id)
    {
        $productModel = new Product();
        $response = $productModel->destroy($id);
        return $this->apiResponse(200, "success", $response);
    }
}
?>
