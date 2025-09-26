<?php
include "config.php";
$pais_id = $_GET['pais_id'] ?? 0;

// Adicionar cidade
if(isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $conn->query("INSERT INTO cidades (nome, pais_id) VALUES ('$nome', $pais_id)");
}

// Deletar cidade
if(isset($_POST['deletar'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM cidades WHERE id=$id");
}

// Buscar cidades
$cidades = $conn->query("SELECT * FROM cidades WHERE pais_id=$pais_id");
$pais = $conn->query("SELECT nome FROM paises WHERE id=$pais_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cidades de <?= $pais['nome'] ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Cidades de <?= $pais['nome'] ?></h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome da cidade" required>
    <button type="submit" name="adicionar">Adicionar Cidade</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Ações</th>
    </tr>
    <?php while($c = $cidades->fetch_assoc()){ ?>
    <tr>
        <td><?= $c['id'] ?></td>
        <td><?= $c['nome'] ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <button type="submit" name="deletar">Excluir</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

<a href="index.php">Voltar</a>

</body>
</html>
