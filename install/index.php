<?php


use olof_spammer\Entity;
use Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Loader;

require_once(__DIR__ . "./../lib/Entity/EmailTable.php");
require_once(__DIR__ . "./../lib/Entity/SubscribeTable.php");
require_once(__DIR__ . "./../lib/Entity/SubscribeTypeTable.php");



class olof_spammer extends CModule
{
    public $MODULE_NAME = "Олоф. Модуль подписок и рассылок";
	public $MODULE_VERSION = '1.0';
  	public $MODULE_VERSION_DATE = '2018-01-24';

    public function __construct()
    {
        $this->MODULE_ID = __CLASS__;
    }

    public function installDB() {
        Entity\EmailTable::getEntity()->createDbTable();
        Entity\SubscribeTable::getEntity()->createDbTable();
        Entity\SubscribeTypeTable::getEntity()->createDbTable();
    }

    public function uninstallDB() {
        $connection = Application::getInstance()->getConnection();
        $connection->dropTable(Entity\EmailTable::getTableName());
        $connection->dropTable(Entity\SubscribeTable::getTableName());
        $connection->dropTable(Entity\SubscribeTypeTable::getTableName());
    }

    public function doInstall()
    {
        $file = __DIR__.'/do-install.php';
        if (file_exists($file)) {
            include $file;
        }

        $this->installDB();
        $this->installAdminPages();


        //$this->addSymlinkAdmin();
		$this->addSymlinkComponents();
        RegisterModule($this->MODULE_ID);

        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible(
            "iblock",
            "OnAfterIBlockElementUpdate",
             $this->MODULE_ID,
            'olof_spammer\events\SpammerIBlockElementUpdateHandler',
            "run"
        );


    }
    protected function installAdminPages()
    {
        $scanned_directory = array_diff(scandir(realpath(__DIR__.'/admin')), array('..', '.'));
        foreach ($scanned_directory as $file) {
            unlink($_SERVER['DOCUMENT_ROOT']."/bitrix/admin/{$file}");
            symlink(
                realpath(__DIR__."/admin/{$file}"),
                $_SERVER['DOCUMENT_ROOT']."/bitrix/admin/{$file}"
            );
        }
    }

    protected function unInstallAdminPages()
    {
        $scanned_directory = array_diff(scandir(realpath(__DIR__.'/admin')), array('..', '.'));
        foreach ($scanned_directory as $file) {
            unlink($_SERVER['DOCUMENT_ROOT']."/bitrix/admin/{$file}");
        }
    }



    public function doUninstall()
    {
        $file = __DIR__.'/do-uninstall.php';
        if (file_exists($file)) {
            include $file;
        }
        $this->unInstallAdminPages();

        $this->uninstallDB();
		//$this->removeSymlinkAdmin();
		$this->removeSymlinkComponents();

        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler(
            "iblock",
            "OnAfterIBlockElementUpdate",
             $this->MODULE_ID,
            'olof_spammer\events\SpammerIBlockElementUpdateHandler',
            "run"
        );

        UnRegisterModule($this->MODULE_ID);
    }

	public function addSymlinkAdmin()
	{
		$dir = __DIR__.'/../admin';
		if (!file_exists($dir)) {
			return;
		}

		$pages = scandir($dir);
		foreach ($pages as $page) {
			if (in_array($page, ['.', '..', 'menu.php'])) {
				continue;
			}
			symlink(
				$dir.'/'.$page,
				$this->getBitrixAdminPageName($page)
			);
		}
	}

	public function addSymlinkComponents()
	{
		$dir = __DIR__.'/../components';
		if (file_exists($dir)) {
			symlink($dir, $this->getBitrixComponentsDir());
		}
	}

	public function removeSymlinkAdmin()
	{
		$dir = __DIR__.'/../admin';
		if (!file_exists($dir)) {
			return;
		}

		$pages = scandir($dir);
		foreach ($pages as $page) {
			if (in_array($page, ['.', '..', 'menu.php'])) {
				continue;
			}
			unlink($this->getBitrixAdminPageName($page));
		}
	}

	public function removeSymlinkComponents()
	{
		$dir = $this->getBitrixComponentsDir();
		if (file_exists($dir)) {
			unlink($dir);
		}
	}

	protected function getBitrixComponentsDir()
	{
		return $_SERVER['DOCUMENT_ROOT'].'/bitrix/components/'.$this->MODULE_ID;
	}

	protected function getBitrixAdminPageName(string $page)
	{
		return $_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$page;
	}
}
