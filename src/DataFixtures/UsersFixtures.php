<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $items = $this->getDatas();

        foreach ($items as $item) {
            $entity = new User();
            $password = $this->passwordEncoder->encodePassword($entity, $item['password']);
            $entity->setPassword($password);
            $entity->setEmail($item['email']);
            $entity->setRoles($item['roles']);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    protected function getDatas()
    {
        return [
            [
                'firstname' => 'Fabrice',
                'lastname' => 'Gyre',
                'email' => 'fabrice@touch-agency.net',
                'password' => 'fabrice',
                'roles' => ['ROLE_ADMIN'],
            ],
            [
                'firstname' => 'Manu',
                'lastname' => 'Pain',
                'email' => 'manu@touch-agency.net',
                'password' => 'manu',
                'roles' => ['ROLE_CLIENT'],
            ],
        ];
    }
}
