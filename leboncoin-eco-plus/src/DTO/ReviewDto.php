<?php

namespace App\DTO;

use App\Entity\Review;
use App\Entity\User;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

class ReviewDto {

    private User $user;
    private User $reviewer;

    #[Assert\NotBlank]
    #[Assert\LessThanOrEqual(5)]
    #[Assert\GreaterThanOrEqual(0)]
    private int $rate;

    #[Assert\Length(max: 4096)]
    public ?string $comment = '';

    private DateTime $date;

    public function getUser(): User {return $this->user;}
    public function setUser(User $user): void {$this->user = $user;}

    public function getReviewer(): User {return $this->reviewer;}
    public function setReviewer(User $reviewer): void {$this->reviewer = $reviewer;}

    public function getRate(): int {return $this->rate;}
    public function setRate(int $rate): void {$this->rate = $rate;}

    public function getComment(): ?string {return $this->comment;}
    public function setComment(?string $comment): void {$this->comment = $comment;}

    public function getDate(): ?DateTime {return $this->date;}
    public function setDate(?DateTime $date): void {$this->date = $date;}


    public function setFromEntity(Review $review): void {
        $this->user = $review->getUser();
        $this->reviewer = $review->getReviewer();
        $this->rate = $review->getRate();
        $this->date = $review->getDate();
        if ($review->getComment()) $this->comment = $review->getComment();
    }
    public function setEntityFromDto(Review $review): void {
        $review->setRate($this->rate);
        if ($this->comment) $review->setComment($this->comment);
    }
}