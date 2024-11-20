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
        // Mendapatkan semua sertifikat
        $stmt = $pdo->prepare("SELECT * FROM certificates");
        $stmt->execute();
        $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($certificates);
        break;

    case 'POST':
        // Menambahkan sertifikat baru
        $name = $_POST['name'];
        
        if (isset($_FILES['image'])) {
            $targetDir = "uploads/";
            $fileName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath);

            $stmt = $pdo->prepare("INSERT INTO certificates (name, image_url) VALUES (:name, :image_url)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':image_url', $targetFilePath);
            $stmt->execute();
            echo json_encode(["message" => "Certificate added successfully"]);
        } else {
            echo json_encode(["message" => "Image file not uploaded"]);
        }
        break;

    case 'DELETE':
        // Menghapus sertifikat
        parse_str(file_get_contents("php://input"), $_DELETE);
        $stmt = $pdo->prepare("DELETE FROM certificates WHERE id = :id");
        $stmt->bindParam(':id', $_DELETE['id']);
        $stmt->execute();
        echo json_encode(["message" => "Certificate deleted successfully"]);
        break;

    default:
        echo json_encode(["message" => "Method not supported"]);
        break;
}
?>