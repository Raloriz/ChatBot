<?php
/**
 * Created by PhpStorm.
 * User: Raloriz
 * Date: 06.02.2019
 * Time: 17:11
 */

namespace App\Controller;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BotManController extends AbstractController
{
    /**
     * @Route("/", name="botMan")
     */
    public function index()
    {
        $config = [
            'facebook' => [
                'token' => 'EAAIoZCLiJgxQBAJI7MPTTcavPR7Oo2ZAbyJ2J2tFjcHBWpovW12UOPBz0cANzuh8zV8mEok78He7gxzwLOEMlELBYbOzPhYjSs8gEri5MPNXISDPieTk8t9KvIQOvOL4Q34SdNbI8IWebw87kQiAfvPuY2ZAL9ZBZCZBZCksxwrCQZDZD',
                'app_secret' => 'a8721b65f98c3765568c47b87701b01e',
                'verification'=>'Qwerqwer1@',
            ]
        ];

        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

        $botMan = BotManFactory::create($config);

        $botMan->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello yourself.');
        });

        $botMan->listen();

    }


}