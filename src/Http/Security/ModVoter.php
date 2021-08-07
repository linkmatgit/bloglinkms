<?php

namespace App\Http\Security;

use App\Domain\Auth\User;
use App\Domain\Mods\Entity\Mod;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use const App\Domain\Manager\REVISION;

class ModVoter extends Voter
{

    const CREATE = 'modCreate';
    const EDIT =  'modEdit';
    const APPROUVED =  'approuvedMod';
    protected function supports(string $attribute, $subject)
    {
        return in_array($attribute, [
            self::CREATE,
            self::EDIT,
            self::APPROUVED

        ]);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        switch ($attribute) {
            case self::CREATE:
                return $this->createMods($user);
            case self::EDIT:
                return $this->editMods($subject, $user);
            case self::APPROUVED:
                return $this->approuvedMod($user, $subject);
        }

        return false;
    }

    private function createMods(User $user): bool
    {
        return $user->banned == false;
    }
    private function editMods(Mod $mod, User $user): bool
    {
      return $this->checkIfApprouve($mod);
    }
    private function approuvedMod(User $user, Mod $mod): bool
    {
        return false;
    }
    private function checkIfApprouve(Mod $mod):bool {
        return null !== $mod->getApprouveBy();
    }
}
