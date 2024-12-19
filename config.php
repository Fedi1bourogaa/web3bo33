
<?php
class config {
    // Déclaration de la variable statique pour la connexion PDO
    private static $pdo = null;

    // Méthode pour obtenir la connexion PDO
    public static function getConnexion() {
        // Si la connexion n'a pas encore été établie
        if (!isset(self::$pdo)) {
            // Paramètres de connexion à la base de données
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "elhadhra"; // Le nom de votre base de données
            

            try {
                // Création de la connexion PDO
                //self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);


                
                // Définir le mode d'erreur pour la gestion des erreurs
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Définir le mode de récupération par défaut
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // En cas d'erreur, afficher un message et arrêter le script
                die('Erreur: ' . $e->getMessage());
            }
        }

        // Retourner l'objet PDO
        return self::$pdo;
    }
}

// Appel de la méthode pour obtenir la connexion
config::getConnexion();


/*class config {
    private static $pdo = null;

    public static function getConnexion() {
        if (!isset(self::$pdo)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "elhadhra";
            
            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

?>
/*class config
{   private static $pdo = null;
    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            $servername="localhost";
            $username="root";
            $password ="";
            $dbname="elhadhra";
            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname",
                        $username,
                        $password
                   
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
               
               
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
config::getConnexion();*/

