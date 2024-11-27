<?php
// ModelGenerique.php

class ModelGenerique {
    // Instance PDO partagée
    protected static $pdo;

    /**
     * Configure la connexion PDO.
     *
     * @param PDO $pdo Instance PDO.
     */
    public static function setPDO(PDO $pdo) {
        self::$pdo = $pdo;
    }

    /**
     * Exécute une requête SQL avec des paramètres.
     *
     * @param string $query La requête SQL à exécuter.
     * @param array $params Les paramètres à lier à la requête.
     * @return PDOStatement Le résultat de la requête.
     */
    protected function executeReq(string $query, array $params = []) : PDOStatement {
        try {
            $stmt = self::$pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Vous pouvez personnaliser la gestion des erreurs ici
            die("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    }

    /**
     * Récupère le dernier ID inséré.
     *
     * @return int Le dernier ID inséré.
     */
    protected function getLastInsertId() : int {
        return (int) self::$pdo->lastInsertId();
    }

    /**
     * Débogage : Affiche la dernière requête exécutée (optionnel).
     *
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     */
    protected function debugQuery(string $query, array $params = []) {
        echo "<pre>";
        echo "Requête SQL : " . htmlspecialchars($query) . "\n";
        echo "Paramètres : " . print_r($params, true);
        echo "</pre>";
    }
}
?>
