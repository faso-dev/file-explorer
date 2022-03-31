<?php

function getDirectoryToScan(): string
{
    $basePath = 'root';
    $directoryToScan = empty(htmlentities($_GET['path'] ?? ''))
        ? ''
        : get_absolute_path(htmlentities($_GET['path']));

    return sprintf(
        '%s/%s/%s',
        __DIR__,
        $basePath,
        ltrim($directoryToScan, DIRECTORY_SEPARATOR)
    );
}

function get_absolute_path(string $path): string
{
    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
    $absolutes = array();
    foreach ($parts as $part) {
        if ('.' == $part) continue;
        if ('..' == $part) {
            array_pop($absolutes);
        } else {
            $absolutes[] = $part;
        }
    }
    return implode(DIRECTORY_SEPARATOR, $absolutes);
}

function fsize($size, string $unit = "MB"): string
{
    if ((!$unit && $size >= 1 << 30) || $unit == "GB")
        return number_format($size / (1 << 30), 2) . "GB";
    if ((!$unit && $size >= 1 << 20) || $unit == "MB")
        return number_format($size / (1 << 20), 2) . "MB";
    if ((!$unit && $size >= 1 << 10) || $unit == "KB")
        return number_format($size / (1 << 10), 2) . "KB";
    return number_format($size) . " bytes";
}

function dirsort(array $directories): array
{
    usort($directories, function ($dirOne, $dirTwo) {
        if ($dirOne['fileType'] === $dirTwo['fileType']) {
            return 0;
        }
        if ($dirOne['fileType'] === 'Dossier' && $dirTwo['fileType'] === 'Fichier') {
            return -1;
        }
        return 1;
    });

    return $directories;
}

function breadcrumbParts(): array
{
    return array_filter(explode(DIRECTORY_SEPARATOR, $_GET['path'] ?? ''));
}