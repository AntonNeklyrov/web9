<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\User;
use \DateTime;

class AppFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 5; $i++) {
            $post = new Post();
            $post->setPostLabel("Постер" . $i);
            $post->setPostImg("user/img/" . uniqid() . ".png");
            $post->setPostData((string)$this->generateDate());
            $post->setPostTrailer("https://www.youtube.com/" . uniqid());
            $post->setPostStatus(true);
            $manager->persist($post);
        }

        for ($i=5; $i < 10; $i++) {
            $post = new Post();
            $post->setPostLabel("Постер" . $i);
            $post->setPostImg("user/img/" . uniqid() . ".png");
            $post->setPostData((string)$this->generateDate());
            $post->setPostTrailer("https://www.youtube.com/" . uniqid());
            $post->setPostStatus(false);
            $manager->persist($post);
        }

        for ($i=0; $i < 15; $i++) {
            $user = new User();
            $user->setUserName('Имя - '.$i);
            $user->setUserSurname('Фамилия - ' . $i);
            $user->setUserEmail('email'.$i.'@mail.com');
            $user->setUserPhone(rand(1_000_000_000, 9_999_999_999));
            $user->setUserPassword($i*$i);
            $user->setIsAdmin((bool)random_int(0, 1));
            if($i % 4 == 0){
                $user->setRoles(["ROLE_ADMIN"]);
            }
            else
                $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
        }

        $manager->flush();
    }


    private function generateDate() : DateTime
    {
        $randDate = rand(2020, 2022) . '-' . rand(1, 12) . '-' . rand(1, 29) . ' ' .
            rand(10, 23) . ':' . rand(10, 59) . ':' . rand(10, 59);
        return DateTime::createFromFormat('Y-m-d H:i:s', $randDate);
    }

}
