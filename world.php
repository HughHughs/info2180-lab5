<?php
//Connect to the database
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    //gets country and lookup type from url
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $lookup  = isset($_GET['lookup']) ? $_GET['lookup'] : '';

    if ($lookup === "cities") {
        //searches for cities in the specified country
        $stmt = $conn->prepare("
            SELECT cities.name AS city_name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");
        $stmt->bindValue(':country', "%$country%");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        if (!empty($country)) {
            //Searches for countries matching the input
            $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE :country");
            $stmt->bindValue(':country', "%$country%");
            $stmt->execute();
        } else {
            //Returns all countries
            $stmt = $conn->query("SELECT * FROM countries");
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
    exit();
}
?>

<?php if (count($results) > 0): ?>
<?php if ($lookup === "cities"): ?>
<!-- Displays the city results in a table -->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['city_name']) ?></td>
            <td><?= htmlspecialchars($row['district']) ?></td>
            <td><?= htmlspecialchars($row['population']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<!-- Displays the country results in a table-->
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Country Name</th>
            <th>Continent</th>
            <th>Independence Year</th>
            <th>Head of State</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['continent']) ?></td>
            <td><?= htmlspecialchars($row['independence_year']) ?></td>
            <td><?= htmlspecialchars($row['head_of_state']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
<?php else: ?>
<p>No <?= $lookup === "cities" ? "cities" : "countries" ?> found.</p>
<?php endif; ?>
