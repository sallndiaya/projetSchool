<?php
require 'db.php';

if (isset($_GET['school_id'])) {
    $school_id = (int)$_GET['school_id'];

    $stmt = $pdo->prepare("SELECT * FROM classes WHERE ecole_id = ?");
    $stmt->execute([$school_id]);
    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($classes);
}
?>
