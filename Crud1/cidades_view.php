<?php
include("config.php");
include("cidades.php");

// Verifica se o país foi passado
if (!isset($_GET['pais_id'])) {
    die("ID do país não informado!");
}
$pais_id = $_GET['pais_id'];

// Busca nome do país
$stmt = $conn->prepare("SELECT nome FROM paises WHERE id=?");
$stmt->bind_param("i", $pais_id);
$stmt->execute();
$result = $stmt->get_result();
$pais = $result->fetch_assoc();

// Lista cidades
$cidades = listarCidades($pais_id);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cidades de <?= htmlspecialchars($pais['nome']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Cidades de <?= htmlspecialchars($pais['nome']) ?></h2>

    <!-- Formulário para adicionar -->
    <form action="cidades.php?acao=adicionar" method="POST" class="form-inline">
        <input type="hidden" name="pais_id" value="<?= $pais_id ?>">
        <input type="text" name="nome" placeholder="Nome da cidade" required>
        <button type="submit" class="btn add">Adicionar</button>
    </form>

    <!-- Listagem -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cidade</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cidades as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nome']) ?></td>
                    <td>
                        <a href="editar_cidades.php?id=<?= $c['id'] ?>&pais_id=<?= $pais_id ?>" class="btn edit">Editar</a>
                        <form action="cidades.php?acao=deletar&id=<?= $c['id'] ?>&pais_id=<?= $pais_id ?>" method="POST" style="display:inline">
                            <button type="submit" class="btn delete" onclick="return confirm('Excluir cidade?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="index.php" class="btn back">← Voltar para Países</a>
</div>
</body>
</html>

