<?php
/**
 * Created by PhpStorm.
 * User: jkorn2324
 * Date: 2019-07-01
 * Time: 22:01
 */

declare(strict_types=1);

namespace kitkb\commands;


use kitkb\KitKb;
use kitkb\Player\KitKbPlayer;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class DeleteKitCommand extends Command
{
    public function __construct()
    {
        parent::__construct('create-kit', 'Creates a kit with all items from inventory.', 'Usage: /create-kit <name>', ['kit-create']);
        parent::setPermission('permission.kit.create');
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param string[] $args
     *
     * @return mixed
     */
    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        $msg = null;

        if($sender instanceof KitKbPlayer) {
            if($this->testPermission($sender)) {
                $size = count($args);
                if($size === 1 and isset($args[0])) {
                    $name = strval($args[0]);
                    $kitHandler = KitKb::getKitHandler();
                    if($kitHandler->isKit($name)) {
                        $kitHandler->deleteKit($name);
                        $msg = TextFormat::GREEN . 'Successfully deleted a kit.';
                    } else $msg = TextFormat::RED . 'Failed to delete kit. Reason: Kit does not exist.';
                } else $msg = $this->getUsage();
            }
        } else $msg = KitKb::getConsoleMsg();

        if($msg !== null) $sender->sendMessage($msg);

        return true;
    }
}