<?php
include 'config.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER["REQUEST_METHOD"];

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit();

switch ($requestMethod) {
    case 'GET':
        // Mendapatkan semua layanan
        $stmt = $pdo->prepare("SELECT * FROM services");
        $stmt->execute();
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($services);
        break;

    case 'POST':
        // Menambahkan layanan baru
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO services (name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->execute();
        echo json_encode(["message" => "Service added successfully"]);
        break;

    case 'PUT':
        // Mengedit layanan
        parse_str(file_get_contents("php://input"), $_PUT);
        $stmt = $pdo->prepare("UPDATE services SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':name', $_PUT['name']);
        $stmt->bindParam(':description', $_PUT['description']);
        $stmt->bindParam(':id', $_PUT['id']);
        $stmt->execute();
        echo json_encode(["message" => "Service updated successfully"]);
        break;

    case 'DELETE':
        // Menghapus layanan
        parse_str(file_get_contents("php://input"), $_DELETE);
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = :id");
        $stmt->bindParam(':id', $_DELETE['id']);
        $stmt->execute();
        echo json_encode(["message" => "Service deleted successfully"]);
        break;

    default:
        echo json_encode(["message" => "Method not supported"]);
        break;
}
?>