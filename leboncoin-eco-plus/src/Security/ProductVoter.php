<?php
// src/Security/PostVoter.php
namespace App\Security;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProductVoter extends Voter {
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    private Security $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Product) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) return false; // the user must be logged in; if not, deny access
        if ($this->security->isGranted('ROLE_ADMIN')) return true;

        // you know $subject is a Post object, thanks to `supports()`
        /** @var Product $product */
        $product = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($product, $user);
            case self::EDIT:
                return $this->canEdit($product, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    // I know this is useless it's for future use case
    private function canView(Product $product, User $user): bool {
        // the Post object could have, for example, a method `isPrivate()`
        return $this->canEdit($product, $user);
    }

    private function canEdit(Product $product, User $user): bool {
        // this assumes that the Post object has a `getOwner()` method
        return $user === $product->getUser();
    }
}