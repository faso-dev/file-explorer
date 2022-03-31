<?php

class FileScannerService
{


    public static function getRootDirectories($directory): array
    {
        // initialization of the pdf table
        $directories = [];
        if (is_dir($directory)) {

            $scannedDirectories = array_diff(scandir($directory), array('..', '.'));

            foreach ($scannedDirectories as $scannedDirectory) {
                $directories[] = [
                    'name' => $scannedDirectory,
                    'fileType' => filetype($directory . DIRECTORY_SEPARATOR . $scannedDirectory) === 'dir' ? 'Dossier' : 'Fichier',
                ];
            }
        }

        return dirsort($directories);
    }

    public static function getDirectoryContent($directory): array
    {
        $files = [];
        if (is_dir($directory)) {

            $directoryContents = array_diff(scandir($directory), array('..', '.'));

            foreach ($directoryContents as $directoryContent) {
                $fileName = $directoryContent;
                $filePath = $directory . DIRECTORY_SEPARATOR . $directoryContent;
                $files[] = [
                    'id' => md5($fileName),
                    'fileType' => filetype($filePath) === 'dir' ? 'Dossier' : 'Fichier',
                    'name' => $fileName,
                    'url' => htmlentities($_GET['path']) . DIRECTORY_SEPARATOR . $fileName,
                    'last_modified' => date(
                        'd.m.Y H:i',
                        filemtime($filePath)
                    ),
                    'size' => fsize(filesize($filePath))
                ];
            }
        }
        return dirsort($files);

    }
}