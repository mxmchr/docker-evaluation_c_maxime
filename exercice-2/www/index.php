<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des articles</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste des articles</h1>
    <p><?php echo $_ENV['CLIENT_MESSAGE']; ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Contenu</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Récupérer les variables d'environnement pour la connexion à la base de données
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];

            // Établir une connexion à la base de données
            $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $pdo = new PDO($dsn, $user, $pass, $options);

                // Exécuter une requête SQL pour récupérer les articles depuis la base de données
                $stmt = $pdo->query('SELECT * FROM article');

                // Afficher les résultats dans le tableau HTML
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['title']}</td>";
                    echo "<td>{$row['body']}</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                // Gérer les erreurs de connexion à la base de données
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
</body>
</html>
