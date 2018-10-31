<?php

namespace AppBundle\Tests;

use AppBundle\Entity\Contact;
use AppBundle\Entity\File;
use AppBundle\Form\Transformer\FileToEntityTransformer;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Mockery as m;

class ContactTest extends TypeTestCase
{
    private $fileToEntityTransformer;

    private $file;

    private $uploadedFile;

    protected function setUp()
    {
        $this->file = m::mock(File::class);
        $this->uploadedFile = [
            'name' => 'test',
            'type' => 'test',
            'size' => '1',
            'tmp_name' => 'test',
            'error' => UPLOAD_ERR_OK
        ];
        $this->fileToEntityTransformer = m::mock(FileToEntityTransformer::class)
            ->shouldReceive('reverseTransform')
            ->with($this->uploadedFile)
            ->andReturn($this->file)->getMock();
        $this->fileToEntityTransformer
            ->shouldReceive('transform')
            ->with(null)
            ->andReturn(null)
            ->getMock();
        parent::setUp();
    }

    protected function getExtensions()
    {
        $type = new \AppBundle\Form\Contact($this->fileToEntityTransformer);
        $validator = m::mock(ValidatorInterface::class);
        $validator
            ->shouldReceive('validate')
            ->andReturn(new ConstraintViolationList());
        $validator
            ->shouldReceive('getMetadataFor')
            ->andReturn(new ClassMetadata(Form::class));

        return array(
            new PreloadedExtension(array($type), array()),
            new ValidatorExtension($validator),
        );
    }

    public function testSubmitValidData()
    {
        $formData = array(
            'address' => 'Streetname, 40',
            'birthday' => '2001-04-01',
            'firstName' => 'Test',
            'lastName' => 'Smith',
            'city' => 'Frankfurt',
            'phone' => '017 3616 2372',
            'zip' => '61093',
            'email' => 'test@test.com',
            'country' => 'Germany',
            'avatar' => $this->uploadedFile
        );

        $actual = new Contact();
        $form = $this->factory->create(\AppBundle\Form\Contact::class, $actual);

        $expected = new Contact();
        $expected->setAddress('Streetname, 40');
        $expected->setBirthday(new \DateTime('04/01/2001'));
        $expected->setFirstName('Test');
        $expected->setLastName('Smith');
        $expected->setCity('Frankfurt');
        $expected->setPhone('017 3616 2372');
        $expected->setZip('61093');
        $expected->setEmail('test@test.com');
        $expected->setCountry('Germany');
        $expected->setAvatar($this->file);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($expected, $actual);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
