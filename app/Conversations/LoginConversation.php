<?php

namespace App\Conversations;

use App\Repositories\UserRepository;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class LoginConversation extends Conversation
{
    protected $email;
    protected $password;

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }
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


            if ($data = $this->userRepo->login($this->email, $this->password)) {
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
