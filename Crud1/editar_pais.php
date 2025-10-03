<?php
include("config.php");

// Verifica se ID foi passado
if (!isset($_GET['id'])) {
    die("ID do país não informado!");
}

$id = $_GET['id'];

// Busca dados do país
$stmt = $conn->prepare("SELECT * FROM paises WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pais = $result->fetch_assoc();

$continentes = [
    1 => "América do Sul",
    2 => "América do Norte",
    3 => "Europa",
    4 => "África",
    5 => "Ásia",
    6 => "Oceania"
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar País</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Editar País</h2>

    <form action="paises.php?acao=editar" method="POST">
        <input type="hidden" name="id" value="<?= $pais['id'] ?>">

        <label>Nome do País:</label>
        <input type="text" name="nome" value="<?= $pais['nome'] ?>" required>

        <label>Continente:</label>
        <select name="continente_id" required>
            <?php foreach ($continentes as $key => $nome): ?>
                <option value="<?= $key ?>" <?= $pais['continente_id'] == $key ? "selected" : "" ?>>
                    <?= $nome ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn edit">Salvar Alterações</button>
    </form>

    <a href="index.php" class="btn back">← Voltar</a>
</div>
</body>
</html>
