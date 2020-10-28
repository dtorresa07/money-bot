<?php

namespace App\Conversations;

use App\Http\Controllers\UserController;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;

class RegisterConversation extends Conversation
{
    protected $name;
    protected $email;
    protected $password;
    protected $password_confirmation;

    public function askName()
    {
        $this->ask(
            'First of all, I need your name',
            function (Answer $answer) {
                $this->name = $answer->getText();
                $this->askEmail();
            }
        );
    }

    public function askEmail()
    {
        $this->ask(
            $this->name . ', can you please share with me your email',
            function (Answer $answer) {
                $this->email = $answer->getText();
                $this->askPassword();
            }
        );
    }

    public function askPassword()
    {
        $this->ask(
            'Now, can you please creaate a pasword for your account',
            function (Answer $answer) {
                $this->password = $answer->getText();
                $this->askPasswordConfirmation();
            }
        );
    }

    public function askPasswordConfirmation()
    {
        $this->ask(
            'Write your paswword again, for confirmation',
            function (Answer $answer) {
                $this->password_confirmation = $answer->getText();

                if ($this->password != $this->password_confirmation) {
                    $this->say('It seems the password doesn´t match, let´s do it again');
                    $this->askPassword();
                } else {
                    $params = [
                        "name" => $this->name,
                        "email" => $this->email,
                        "password" => $this->password
                    ];

                    $new_user = new UserController;
                    $data = $new_user->register($params);

                    $this->say('Great - that is all we need, ' . $this->name . '|' . json_encode($params));
                    $this->say('You are logged now');


                    /*
                                        try {
                                            $newUser = new UserController;
                                            $data = $newUser->register($params);

                                        } catch (Exception $e) {
                                            if ($e->getCode() == 400) {
                                                $this->say('Something went wrong check bellow...<br /><b> - ' . $e->getMessage() . '</b>');
                                            } else {
                                                $this->say('Sometime went wrong, please don´t give up on me, try again....');
                                                $this->askName();
                                            }
                                        }
                                        */
                }
            }
        );
    }

    public function run()
    {
        $this->askName();
    }
}
