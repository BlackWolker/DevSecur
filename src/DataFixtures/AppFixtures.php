<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use \App\Entity\Message;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $connection = $manager->getConnection();
        $connection->executeStatement("DBCC CHECKIDENT ('user', RESEED, 0);");
        $connection->executeStatement("DBCC CHECKIDENT ('message', RESEED, 0);");

        // User avec role User
        $user1 = new User();
        $user1->setLastName("tata");
        $user1->setFirstName("tata");
        $user1->setEmail("tata@test.com");
        $user1->setRoles(["ROLE_USER"]);
        $pwd1 = $this->hasher->hashPassword($user1, 'password');
        $user1->setPassword($pwd1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setLastName("toto");
        $user2->setFirstName("toto");
        $user2->setEmail("toto@test.com");
        $user2->setRoles(["ROLE_USER"]);
        $pwd2 = $this->hasher->hashPassword($user2, 'password');
        $user2->setPassword($pwd2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setLastName("vivi");
        $user3->setFirstName("toto");
        $user3->setEmail("vivi@test.com");
        $user3->setRoles(["ROLE_USER"]);
        $pwd3 = $this->hasher->hashPassword($user3, 'password');
        $user3->setPassword($pwd3);
        $manager->persist($user3);


        $message1 = new Message();
        $message1->setTitle("ghddggfhhbdh");
        $message1->setText("dfgdyzvyivfyizviyvz");
        $message1->setCustomer($user1);
        $manager->persist($message1);

        $message2 = new Message();
        $message2->setTitle("commentaire");
        $message2->setText("dfgdyzvyivfyizviyvz");
        $message2->setCustomer($user2);
        $manager->persist($message2);

        $message3 = new Message();
        $message3->setTitle("commentaire");
        $message3->setText("dfgdyzvyivfyizviyvz");
        $message3->setCustomer($user3);
        $manager->persist($message3);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
