<?php

namespace App\Tests\Form\Transformer;

use App\Entity\File;
use App\Form\Transformer\FileToEntityTransformer;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use Ramsey\Uuid\Uuid;

class FileToEntityTransformerTest extends TestCase
{
    public function testTransform()
    {
        $transformer = new FileToEntityTransformer('/tmp');
        $tmpFile = tempnam('/tmp', 'test-trans');
        $file = m::mock(File::class)->allows([
                'getPath' => '/tmp',
                'getFilename' => basename($tmpFile)
            ]
        );
        $transformed = $transformer->transform($file);
        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\File\File::class, $transformed);
        $this->assertEquals('/tmp', $transformed->getPath());
        $this->assertEquals(basename($tmpFile), $transformed->getFilename());
        unlink($tmpFile);
    }

    public function testTransformEmpty()
    {
        $transformer = new FileToEntityTransformer('/tmp');
        $this->assertNull($transformer->transform(null));
    }

    public function testReverseTransform()
    {
        $transformer = new FileToEntityTransformer('/tmp');
        $file = m::mock(\Symfony\Component\HttpFoundation\File\File::class)->allows([
                'move' => true,
                'getMimeType' => 'valid/mime',
                'guessExtension' => 'mime',
            ]
        );
        $transformed = $transformer->reverseTransform($file);
        $this->assertInstanceOf(File::class, $transformed);
        $this->assertEquals('valid/mime', $transformed->getMime());
        $info = pathinfo($transformed->getFilename());
        $this->assertTrue(Uuid::isValid($info['filename']));
        $this->assertEquals('mime', $info['extension']);
    }

    public function testReverseTransformEmpty()
    {
        $transformer = new FileToEntityTransformer('/tmp');
        $transformed = $transformer->reverseTransform(null);
        $this->assertNull($transformed);
    }
}
