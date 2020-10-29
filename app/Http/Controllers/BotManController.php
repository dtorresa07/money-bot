<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use App\Services\CurrencyAPIService;
use Illuminate\Support\Facades\Auth;
use App\Conversations\LoginConversation;
use App\Conversations\RegisterConversation;

class BotManController extends Controller
{
    protected $registerConversation;
    protected $loginConversation;

    public function __construct(
        RegisterConversation $registerConversation,
        LoginConversation $loginConversation
    ) {
        $this->registerConversation = $registerConversation;
        $this->loginConversation = $loginConversation;
    }
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function ($botman, $message) {
            switch (strtolower(trim($message))) {
                case 'register':
                    $botman->startConversation($this->registerConversation);
                    break;
                case 'login':
                    $botman->startConversation($this->loginConversation);
                    break;
                case 'list currencies':
                    $this->listCurrencies($botman);
                    break;
                case 'user':
                    $this->showUser($botman);
                    break;
                default:
                    $botman->reply("write 'hi' for testing...");
            }
        });

        $botman->listen();
    }

    public function listCurrencies($botman)
    {
        try {
            $currencyAPIService = new CurrencyAPIService();
            $message = "All currencies<br />";
            $currencyList = [];
            foreach ($currencyAPIService->getCurrencyList() as $currency) {
                $currencyList[] = '<b>' . $currency['currency'] . '</b> - ' . $currency['description'];
            }

            $message .= implode("<br />", $currencyList);

            $botman->reply($message);
        } catch (Exception $e) {
            if ($e->getCode() == 400) {
                $botman->reply("So, it seems we have an error " . $e->getMessage());
            } else {
                $botman->reply("Something failed, please try again...");
            }
        }
    }

    public function showUser($botman)
    {
        $user = Auth::user();
        if (Auth::check()) {
            $botman->reply("Autenticado" . $user->name);
        } else {
            $botman->reply("No autenticado");
        }
    }
}
