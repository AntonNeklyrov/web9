<?php

namespace App\Tests;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @property $factory
 */
class PostTypeTest extends WebTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'post_label' => 'testLabel',
            'post_img' => 'testImg',
            'post_data' => 'testData',
            'post_trailer' => 'testUrl'
        ];

        $model = new Post();

        $form = $this->factory->create(Post::class, $model);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $expected = new Post();

        $expected->setPostLabel('testLabel');
        $expected->setPostImg('testImg');
        $expected->setPostTrailer('testUrl');
        $expected->setPostData('testData');

        $this->assertEquals($expected, $model);

    }
}
