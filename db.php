<?php
if (!class_exists('Connexion')) {
    class Connexion
    {
        private static ?PDO $pdo = null;

        public static function getConnexion(): PDO
        {
            if (self::$pdo === null) {
                $servername = getenv('DB_SERVER') ?: 'localhost';
                $dbname = getenv('DB_NAME') ?: 'elhadhra';
                $username = getenv('DB_USER') ?: 'root';
                $password = getenv('DB_PASSWORD') ?: '';

                try {
                    self::$pdo = new PDO(
                        "mysql:host=$servername;dbname=$dbname;charset=utf8mb4",
                        $username,
                        $password
                    );
                    self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    // Enregistrez l'erreur dans un fichier log
                    error_log("PDO Error: " . $e->getMessage(), 3, "errors.log");
                    // Message générique pour l'utilisateur
                    die("Erreur de connexion à la base de données.");
                }
            }
            return self::$pdo;
        }
    }
}
?>
