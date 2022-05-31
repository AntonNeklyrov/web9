<?php

namespace App\DataFixtures;

use App\Entity\Comment;
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
            $user->setApiToken("apiToken".($i+1));

            $manager->persist($user);

            for($j=0; $j < 10; $j++){
                $post = new Post();
                $post->setPostLabel("Постер" . $i + $j);
                $post->setPostImg("user/img/" . uniqid() . ".png");
                $post->setPostData($this->generateDate());
                $post->setPostTrailer("https://www.youtube.com/" . uniqid());
                if($j % 2 == 0){
                    $post->setPostStatus(false);
                }
                else $post->setPostStatus(true);
                $post->setAuthor($user);
                $manager->persist($post);

                for($k=0; $j < 4; $k++){
                    $comment = new Comment();
                    $comment->setDate($this->generateDate());
                    $comment->setPost($post);
                    if($k % 2 == 0){
                        $comment->setStatus(false);
                    }
                    else $comment->setStatus(true);
                    $comment->setText("Комментарий " . $k+1);
                    $comment->setAuthor($user);

                    $manager->persist($comment);
                }
            }
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
