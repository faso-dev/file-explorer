<?php
$path = '';
$route = explode('?', $_SERVER['REQUEST_URI'])[0];
if ('/api' === $route && !(empty(htmlentities($_GET['path'] ?? '')))) :
    $files = FileScannerService::getDirectoryContent(getDirectoryToScan());
    ?>
    <div class="directories-preview-col__header">
        <ul class="breadcrumb">
            <?php
            $parts = breadcrumbParts();
            $partsEnd = end($parts);
            ?>
            <?php foreach ($parts as $part)  : ?>
                <?php $path .= DIRECTORY_SEPARATOR . $part; ?>
                <li class="breadcrumb__item <?= $part === $partsEnd ? 'current-dir' : 'directory' ?>" data-path="<?= $path ?>">
                    <?= ucfirst($part) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="directories-preview-col__content">
        <ul class="files">
            <?php foreach ($files as $fileInfo) : ?>
                <?php if ($fileInfo['fileType'] === 'Dossier') : ?>
                    <li class="directory" data-path="<?= $fileInfo['url'] ?>">
                <?php else: ?>
                    <li class="file">
                <?php endif; ?>
                <i class="fas fa-<?= $fileInfo['fileType'] === 'Dossier' ? 'folder' : 'file' ?>"></i>
                <span> <?= $fileInfo['name'] ?></span>
                <div class="file-info">
                    <ul>
                        <li>Nom : <?= $fileInfo['name'] ?></li>
                        <li>Type : <?= $fileInfo['fileType'] ?></li>
                        <?php if ($fileInfo['fileType'] === 'Fichier') : ?>
                            <li>Taille : <?= $fileInfo['size'] ?></li>
                        <?php endif; ?>
                        <li>Modifié le : <?= $fileInfo['last_modified'] ?></li>
                    </ul>
                </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php
    exit();
endif;
?>
