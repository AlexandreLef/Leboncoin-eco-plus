<?php

namespace App\DTO;

use App\Entity\Category;
use App\Entity\Message;
use Symfony\Component\Validator\Constraints as Assert;

class MessageDto {
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $title = '';

    #[Assert\NotBlank]
    #[Assert\Length(max: 4096)]
    private string $message = '';

    public function getTitle(): string {return $this->title;}
    public function setTitle(string $title): void {$this->title = $title;}

    public function getMessage(): string {return $this->message;}
    public function setMessage(string $message): void {$this->message = $message;}

    public function setFromEntity(Message $message): void {
        $this->title = $message->getTitle();
        $this->message = $message->getMessage();
    }
    public function setEntityFromDto(Message $message): void {
        $message->setTitle($this->title);
        $message->setMessage($this->message);
    }
}