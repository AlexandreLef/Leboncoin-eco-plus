<?php
// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Review;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ReviewVoter extends Voter {
    // these strings are just invented: you can use anything
    const ADD = 'add';

    protected function supports(string $attribute, $subject): bool {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::ADD])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool {
        $user = $token->getUser();
        if (!$user instanceof User) return false; // the user must be logged in; if not, deny access

        // you know $subject is a Post object, thanks to `supports()`
        /** @var User $reviewedUser */
        $reviewedUser = $subject;

        switch ($attribute) {
            case self::ADD:
                return $this->canAdd($reviewedUser, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }


    private function canAdd(User $reviewedUser, User $user): bool {
        $reviews = $reviewedUser->getReviews();
        foreach($reviews as $tmpReview) {
            if ($tmpReview->getReviewer()->getId() == $user->getId()) {
                return false;
            }
        }
        return true;
    }
}