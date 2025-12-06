<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    $country = isset($_GET['country']) ? $_GET['country'] : '';

    if (!empty($country)) {
        $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
        $stmt->bindValue(':country', "%$country%");
        $stmt->execute();
    } else {
        // If no country specified, return all countries
        $stmt = $conn->query("SELECT * FROM countries");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit();
}
?>
<ul>
<?php foreach ($results as $row): ?>
    <li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
