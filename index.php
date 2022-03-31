<?php
require __DIR__ . '/vendor/autoload.php';
$directories = FileScannerService::getRootDirectories(getDirectoryToScan());
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="app.css">
    <title>File Explorer</title>
</head>
<body>
<div class="file-explorer-wraper">
    <div class="directories-col">
        <div class="app-name">
            <span>File Explorer</span>
        </div>
        <ul class="directories">
            <?php foreach ($directories as $directory) : ?>
                <li class="<?= $directory['fileType'] === 'Dossier' ? 'directory' : 'file' ?>" data-path="<?= $directory['name'] ?>">
                    <i class="fas fa-<?= $directory['fileType'] === 'Dossier' ? 'folder' : 'file' ?>"></i>
                    <span><?= ucfirst($directory['name']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="directories-preview-col" id="folder-content">
        <div id="welcome">
            <h5>Veuillez sélectionner un dossier</h5>
        </div>
    </div>
</div>
<script src="app.js"></script>
<script>
    (new FileExplorer()).onClick(function (directory) {
        if (directory.classList.contains('active')) {
            const path = directory.dataset.path
            fetch(window.location.href + 'api?path=' + path)
                .then(res => res.text())
                .then(data => {
                    document.getElementById('folder-content').innerHTML = data
                })
        }
    })
</script>
</body>
</html>