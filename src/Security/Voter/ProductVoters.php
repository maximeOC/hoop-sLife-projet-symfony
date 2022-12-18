<?php

namespace App\Security\Voter;

use App\Entity\Products;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;


Class ProductVoters extends Voter{

    const EDIT = 'PRODUCT_EDIT';
    const DELETE = 'PRODUCT_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $product): bool
    {
        return !in_array($attribute, [self::EDIT, self::DELETE]) && $product instanceof Products;
    }

    protected function voteOnAttribute(string $attribute, $product, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if(!$user instanceof UserInterface){
            return false;
        }

        if($this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        switch ($attribute){
            case self::DELETE:
                return $this->canDelete();
            case self::EDIT:
                return $this->canEdit();
                break;
        }
    }

    private function canEdit(){
        return $this->security->isGranted('PRODUCT_EDIT');
    }
    private function canDelete(){
        return $this->security->isGranted('PRODUCT_DELETE');
    }
}