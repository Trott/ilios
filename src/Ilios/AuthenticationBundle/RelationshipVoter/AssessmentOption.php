<?php

namespace Ilios\AuthenticationBundle\RelationshipVoter;

use AppBundle\Classes\SessionUserInterface;
use AppBundle\Entity\AssessmentOptionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AssessmentOption extends AbstractVoter
{
    protected function supports($attribute, $subject)
    {
        return $subject instanceof AssessmentOptionInterface
            && in_array(
                $attribute,
                [self::CREATE, self::VIEW, self::EDIT, self::DELETE]
            );
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof SessionUserInterface) {
            return false;
        }
        if ($user->isRoot()) {
            return true;
        }

        if ($subject instanceof AssessmentOptionInterface) {
            return self::VIEW === $attribute;
        }

        return false;
    }
}
