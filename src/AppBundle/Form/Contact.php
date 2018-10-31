<?php

namespace AppBundle\Form;


use AppBundle\Form\Transformer\FileToEntityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class Contact extends AbstractType
{
    private $fileTransformer;
    private $permittedMimeTypes = [
        'image/jpeg',
        'image/gif',
        'image/png',
    ];

    public function __construct(FileToEntityTransformer $transformer)
    {
        $this->fileTransformer = $transformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAttribute('class', 'ui form')
            ->add('firstName', TextType::class, ['constraints' => new NotBlank])
            ->add('lastName', TextType::class, ['constraints' => new NotBlank])
            ->add('address', TextType::class, ['constraints' => new NotBlank])
            ->add('zip', TextType::class, ['constraints' => new Length(['min' => 3, 'max' => 8])])
            ->add('city', TextType::class, ['constraints' => new Length(['min' => 2])])
            ->add('country', CountryType::class)
            ->add('phone', TextType::class,['constraints' => new Regex(['pattern' => '/^[+\-0-9\s]{4,}$/'])])
            ->add('birthday', BirthdayType::class, ['widget' => 'single_text'])
            ->add('email', EmailType::class, ['constraints' => new Email])
            ->add(
                'avatar',
                FileType::class,
                [
                    'label_attr' => ['class' => 'field'],
                    'required' => false,
                    'constraints' => new File(['mimeTypes' => $this->permittedMimeTypes])
                ]
            )
            ->add('save', SubmitType::class, ['attr' => ['class' => 'ui primary button']]);
        $builder->get('avatar')->addModelTransformer($this->fileTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\Contact::class,
            'attr' => [
                'class' => 'ui form'
            ]
        ));
    }
}
