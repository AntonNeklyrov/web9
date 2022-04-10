<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $post_label;

    #[ORM\Column(type: 'string', length: 255)]
    private $post_img;

    #[ORM\Column(type: 'string', length: 8)]
    private $post_data;

    #[ORM\Column(type: 'string', length: 255)]
    private $post_trailer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostLabel(): ?string
    {
        return $this->post_label;
    }

    public function setPostLabel(string $post_label): self
    {
        $this->post_label = $post_label;

        return $this;
    }

    public function getPostImg(): ?string
    {
        return $this->post_img;
    }

    public function setPostImg(string $post_img): self
    {
        $this->post_img = $post_img;

        return $this;
    }

    public function getPostData(): ?string
    {
        return $this->post_data;
    }

    public function setPostData(string $post_data): self
    {
        $this->post_data = $post_data;

        return $this;
    }

    public function getPostTrailer(): ?string
    {
        return $this->post_trailer;
    }

    public function setPostTrailer(string $post_trailer): self
    {
        $this->post_trailer = $post_trailer;

        return $this;
    }
}
