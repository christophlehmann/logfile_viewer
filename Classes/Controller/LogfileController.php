<?php
namespace Lemming\LogfileViewer\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class LogfileController extends ActionController
{
    public function indexAction(): string
    {
        $files = glob(Environment::getVarPath() . '/log/*.log');

        $logfiles = [];
        foreach ($files as $file) {
            $logfiles[] = [
                'filename' => basename($file),
                'stat' => stat($file)
            ];
        }

        $this->view->assignMultiple([
            'logfiles' => $logfiles,
            'isAdmin' => self::currentUserIsAdmin()
        ]);
        return $this->view->render();
    }

    public function showAction(string $filename): string
    {
        $content = file_get_contents($this->getFilePath($filename));
        $this->view->assignMultiple([
            'filename' => $filename,
            'lines' => explode(PHP_EOL, $content)
        ]);
        return $this->view->render();
    }

    public function deleteAction(string $filename): string
    {
        if (!self::currentUserIsAdmin()) {
            throw new \Exception('You are not allowed to delete logfiles', 1586107328);
        }

        unlink($this->getFilePath($filename));
        $this->forward('index');
    }

    public function downloadAction(string $filename)
    {
        $file = $this->getFilePath($filename);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    protected function getFilePath(string $filename): string
    {
        return Environment::getVarPath() . '/log/' . basename($filename);
    }

    protected static function currentUserIsAdmin(): bool
    {
        $context = GeneralUtility::makeInstance(Context::class);
        return $context->getPropertyFromAspect('backend.user', 'isAdmin');
    }
}
