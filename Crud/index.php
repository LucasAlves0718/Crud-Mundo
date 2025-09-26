<?php
include "config.php";

// Adicionar país
if(isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $continente_id = $_POST['continente_id'];
    $conn->query("INSERT INTO paises (nome, continente_id) VALUES ('$nome', $continente_id)");
}

// Deletar país
if(isset($_POST['deletar'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM paises WHERE id=$id");
}

// Buscar países e continentes
$paises = $conn->query("SELECT p.id, p.nome, c.nome AS continente FROM paises p JOIN continentes c ON p.continente_id = c.id");
$continentes = $conn->query("SELECT * FROM continentes");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>CRUD Mundo</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Países</h2>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome do país" required>
    <select name="continente_id" required>
        <option value="">Selecione o continente</option>
        <?php while($c = $continentes->fetch_assoc()){ ?>
            <option value="<?= $c['id'] ?>"><?= $c['nome'] ?></option>
        <?php } ?>
    </select>
    <button type="submit" name="adicionar">Adicionar País</button>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Continente</th>
        <th>Ações</th>
    </tr>
    <?php while($p = $paises->fetch_assoc()){ ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['nome'] ?></td>
        <td><?= $p['continente'] ?></td>
        <td>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <button type="submit" name="deletar">Excluir</button>
            </form>
            <form method="GET" action="cidades.php" style="display:inline;">
                <input type="hidden" name="pais_id" value="<?= $p['id'] ?>">
                <button type="submit">Ver Cidades</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
