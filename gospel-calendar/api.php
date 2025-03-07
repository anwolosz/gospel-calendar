<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit(json_encode(['error' => 'Only GET requests are allowed.']));
}

try {
    $db = new PDO('sqlite:calendar.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $date = $_GET['date'] ?? null;

    if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid date format. Use YYYY-MM-DD."]);
        exit;
    }

    $stmt = $db->prepare("SELECT date, colors, gospels FROM calendar WHERE date = :date");
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        echo json_encode([
            "date" => $record['date'],
            "colors" => json_decode($record['colors'], true),
            "gospels" => json_decode($record['gospels'], true)
        ]);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "No record found for $date."]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal Server Error: " . $e->getMessage()]);
}
