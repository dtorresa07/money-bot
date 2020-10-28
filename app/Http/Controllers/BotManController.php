<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use App\Conversations\LoginConversation;
use App\Conversations\RegisterConversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            switch (strtolower(trim($message))) {
                case 'register':
                    $botman->startConversation(new RegisterConversation);
                    break;
                case 'login':
                    $botman->startConversation(new LoginConversation);
                    break;
                default:
                    $botman->reply("write 'hi' for testing...");
            }
        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Hello! What is your Name?', function (Answer $answer) {
            $name = $answer->getText();

            $this->say('Nice to meet you '.$name);
        });
    }
}
