<?php

namespace AppBundle\Form\Transformer;


use AppBundle\Entity\File;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileToEntityTransformer implements DataTransformerInterface
{
    private $fileStoragePath;

    public function __construct($fileStoragePath)
    {
        $this->fileStoragePath = $fileStoragePath;
    }

    /**
     * Transforms a File to Symfony File.
     *
     * @param  File $file
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function transform($file)
    {
        if ($file instanceof File) {
            return new \Symfony\Component\HttpFoundation\File\File($file->getPath() . '/' . $file->getFilename());
        } else {
            return null;
        }
    }

    /**
     * Transforms an uploaded file to a file object
     *
     * @param  UploadedFile $uploadedFile
     * @return File|null
     * @throws TransformationFailedException
     * @throws \Exception
     */
    public function reverseTransform($uploadedFile)
    {
        if (!$uploadedFile) {
            return;
        }
        $file = new File();
        $file->setMime($uploadedFile->getMimeType());
        $uuid = Uuid::uuid4()->toString();
        $file->setKey($uuid);
        $fileName = "{$uuid}.{$uploadedFile->guessExtension()}";
        $file->setFilename($fileName);
        $path = realpath($this->fileStoragePath);
        $uploadedFile->move($path, $fileName);
        $file->setPath($path);

        return $file;
    }
}
