<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $zip;

    /**
     * @ORM\Column(type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=255)
     * @Constraints\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=20, options={"default":""})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, options={"default":""})
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\File", cascade="persist", orphanRemoval=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=2, options={"default":""})
     */
    private $country;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return File
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar(File $avatar = null): self
    {
        if ($avatar) {
            $this->avatar = $avatar;
        }
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }
}
