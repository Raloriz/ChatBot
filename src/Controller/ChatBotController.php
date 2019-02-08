<?php
/**
 * Created by PhpStorm.
 * User: Raloriz
 * Date: 06.02.2019
 * Time: 17:11
 */

namespace App\Controller;

use App\Service\SimpleConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChatBotController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="botMan")
     */
    public function index(Request $request)
    {
        $config = [
            'facebook' => [
                'token' => 'EAAIoZCLiJgxQBAPw7VxOR78Cqu23ZBun1H93LxgtJdsrS3vcDCZBALpBy3HiZALilQIhGZAybwszqjQHsLRjepchbxE0Y0nEdCXZAEc8mLJJWs2Gewiwlv0gKt8nQt2ewZBp46PVokZA1ls6ZCZBEDrOH1QOuWbuoD8EQnvlyxlAw5TQZDZD',
                'app_secret' => 'a8721b65f98c3765568c47b87701b01e',
                'verification'=>'1232342143grfgdffhtygfgfdgdetgh442454523',
            ]
        ];

        DriverManager::loadDriver(\BotMan\Drivers\Facebook\FacebookDriver::class);

        $adapter = new FilesystemAdapter();
        $botMan = BotManFactory::create($config, new SymfonyCache($adapter));

        $botMan->fallback(function(BotMan $bot) {
            $user = $bot->getUser();
            $bot->typesAndWaits(1);
            $bot->reply("Cześć {$user->getFirstName()}!");
            $bot->typesAndWaits(1);
            $bot->startConversation(new SimpleConversation());
        });

        $botMan->listen();
        return new Response();
    }


}