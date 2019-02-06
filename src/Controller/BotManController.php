<?php
/**
 * Created by PhpStorm.
 * User: BartłomiejMichałSobe
 * Date: 06.02.2019
 * Time: 17:11
 */

namespace App\Controller;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;

/**
 * Class BotManController
 * @package App\Controller
 */
class BotManController
{
    public function index()
    {
        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

        // Create BotMan instance
        BotManFactory::create($config);

    }


}