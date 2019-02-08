<?php
/**
 * Created by PhpStorm.
 * User: BartłomiejMichałSobe
 * Date: 07.02.2019
 * Time: 20:51
 */

namespace App\Service;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class SimpleConversation extends Conversation
{
    const MINIMAL_AGE = 13;
    const MAXIMUM_AGE = 100;

    /** @var int */
    protected $age;

    public function askForAge()
    {
        $this->ask('Ile masz lat?', function (Answer $answer) {
            $this->age = (int) $answer->getText();
            $this->ageVerification();
        });
    }

    private function ageVerification()
    {
        if ($this->isInRange()) {
            $birthYear = $this->calculateTheBirthYear();
            $question = Question::create("Dziękuje. Twój rok urodzenia to $birthYear?")
                ->addButtons([
                    Button::create('Tak')->value(true),
                    Button::create('Nie')->value(false)
                ]);
            $this->ask($question, function (Answer $answer) {
                if ($answer->isInteractiveMessageReply()) {
                    $this->checkAnswer($answer->getValue());
                }
            });
        } else {
            $this->ask('Proszę o podanie wieku w zakresie 13 do 100 lat', function (Answer $answer) {
                $this->age = $answer->getText();
                self::ageVerification();
            });
        }
    }

    /**
     * @param bool $option
     */
    private function checkAnswer(bool $option)
    {
        if ($option) {
            $this->say('Świetnie. Dziękuje za odpowiedź.');
        } else {
            $this->askForAge();
        }
    }

    /**
     * @return bool
     */
    private function isInRange(): bool
    {
        return $this->age >= self::MINIMAL_AGE && $this->age <= self::MAXIMUM_AGE;
    }

    /**
     * @return int
     */
    private function calculateTheBirthYear(): int
    {
        return date("Y") - $this->age;
    }

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->askForAge();
    }
}