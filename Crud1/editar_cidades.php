<?php
include("config.php");

// Verifica se cidade e país foram passados
if (!isset($_GET['id']) || !isset($_GET['pais_id'])) {
    die("ID da cidade ou país não informado!");
}

$id = $_GET['id'];
$pais_id = $_GET['pais_id'];

// Busca dados da cidade
$stmt = $conn->prepare("SELECT * FROM cidades WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cidade = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Cidade</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Editar Cidade</h2>

    <form action="cidades.php?acao=editar" method="POST">
        <input type="hidden" name="id" value="<?= $cidade['id'] ?>">
        <input type="hidden" name="pais_id" value="<?= $pais_id ?>">

        <label>Nome da Cidade:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($cidade['nome']) ?>" required>

        <button type="submit" class="btn edit">Salvar Alterações</button>
    </form>

    <a href="cidades_view.php?pais_id=<?= $pais_id ?>" class="btn back">← Voltar</a>
</div>
</body>
</html>
