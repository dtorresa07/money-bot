<?php

namespace App\Conversations;

use App\Http\Controllers\UserController;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class LoginConversation extends Conversation
{
    protected $email;
    protected $password;

    protected $userController;
    /**
     * First question
     */
    public function askEmail()
    {
        $this->ask('To log you in, I need your email', function (Answer $answer) {
            // Save result
            $this->email = $answer->getText();
            $this->askPassword();
        });
    }

    public function askPassword()
    {
        $this->ask('Now, please give me your password', function (Answer $answer) {
            $this->password = $answer->getText();

            $this->userController = new UserController;

            if ($data = $this->userController->login($this->email, $this->password)) {
                $this->say('Welcome ' . $data['name'] . '|' . json_encode($data));
            } else {
                $this->say('Hmm, I don\'t found your email and password in our database.');
            }
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askEmail();
    }
}
