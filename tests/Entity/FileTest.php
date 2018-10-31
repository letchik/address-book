<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\File;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class FileTest extends TestCase
{
    public function testPostRemoveRemovesFile()
    {
        $file = new File();

        $tempFile = tempnam('/tmp', 'file-test-');
        $file->setPath('/tmp');
        $file->setFilename(basename($tempFile));
        touch($tempFile);
        $this->assertTrue(file_exists($tempFile));
        $eventArgs = m::mock(LifecycleEventArgs::class);
        $eventArgs->shouldReceive('getEntity')->andReturn($file);
        $file->removeFile($eventArgs);
        $this->assertFalse(file_exists('/tmp' . '/' . $tempFile));
    }
}
