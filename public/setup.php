<?php
session_set_cookie_params([
    'lifetime' => 86400,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_start();

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

App\Core\Dotenv::load(__DIR__ . '/../.env');

// Redirect if already set up
if (!empty($_ENV['DB_DRIVER'])) {
    try {
        $db = App\Core\Database::getInstance()->getConnection();
        $db->query("SELECT 1 FROM users LIMIT 1");
        header("Location: /");
        die();
    } catch (\Exception $e) {
        // Table doesn't exist, proceed with setup
    }
}

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['host'] ?? '';
    $dbName = $_POST['db_name'] ?? '';
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if (empty($host) || empty($dbName) || empty($user)) {
        $error = 'Bitte fülle Host, Datenbankname und Benutzername aus.';
    } else {
        try {
            $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Connection successful, write .env
            $envContent = "DB_DRIVER=mysql\nDB_HOST=$host\nDB_NAME=$dbName\nDB_USER=$user\nDB_PASS=$pass\n";
            file_put_contents(__DIR__ . '/../.env', $envContent);

            // Reload env and run migrations
            App\Core\Dotenv::load(__DIR__ . '/../.env');
            App\Core\Migrator::migrate();

            $success = true;

        } catch (PDOException $e) {
            $error = 'Datenbankverbindung fehlgeschlagen: ' . $e->getMessage();
        } catch (Exception $e) {
            $error = 'Fehler bei der Migration: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerFlow - Setup</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .setup-container { max-width: 500px; margin: 4rem auto; padding: 2rem; }
        .error { color: #ef4444; margin-bottom: 1rem; background: #fee2e2; padding: 1rem; border-radius: 6px; }
        .success { color: #10b981; margin-bottom: 1rem; background: #d1fae5; padding: 1rem; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="setup-container card">
        <h1>CareerFlow Setup</h1>

        <?php if ($success): ?>
            <div class="success">
                Datenbank erfolgreich verbunden und Tabellen angelegt!
            </div>
            <a href="/" class="btn" style="display: block; text-align: center; text-decoration: none;">Zum Login</a>
        <?php else: ?>
            <p style="margin-bottom: 1.5rem;">Bitte gib die Zugangsdaten für deine MariaDB/MySQL Datenbank ein. Die Tabellen werden automatisch erstellt.</p>

            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Datenbank Host (meistens localhost)</label>
                    <input type="text" name="host" value="localhost" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Datenbank Name</label>
                    <input type="text" name="db_name" required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Benutzername</label>
                    <input type="text" name="user" required>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; margin-bottom: 0.5rem;">Passwort</label>
                    <input type="password" name="pass">
                </div>

                <button type="submit" class="btn" style="width: 100%;">Setup ausführen</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
