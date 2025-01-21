<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
</head>
<body>
    <h1>Test Data</h1>
    <ul>
        <?php foreach ($data as $item): ?>
            <li>ID: <?= htmlspecialchars($item['id']); ?>, Name: <?= htmlspecialchars($item['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
