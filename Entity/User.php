<?php

namespace MarkerTabsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MarkerTabsBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @var int
     *
     * @Annotation\Groups({"id"})
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Annotation\Groups({"user"})
     * @ORM\Column(name="username", type="string", length=25)
     */
    private $username;

    /**
     * @var string
     *
     * @Annotation\Groups({"user"})
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @Annotation\Groups({"admin"})
     * @ORM\Column(name="pass", type="string", length=255)
     */
    private $pass;

    /**
     * @Annotation\Groups({"user_extra", "user_tabs"})
     * @ORM\OneToMany(targetEntity="Tab", mappedBy="user")
     */
    private $tabs;


    /**
     * Constructor
     */
    public function __construct()
	{
        $this->tabs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Add tab
     *
     * @param \MarkerTabsBundle\Entity\Tab $tab
     *
     * @return User
     */
    public function addTab(\MarkerTabsBundle\Entity\Tab $tab)
	{
        $this->tabs[] = $tab;
        return $this;
    }

    /**
     * Get tabs
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getTabs()
	{
        return $this->tabs;
    }

    /**
     * Remove tab
     *
     * @param \MarkerTabsBundle\Entity\Tab $tab
     */
    public function removeTab(\MarkerTabsBundle\Entity\Tab $tab)
	{
        $this->tabs->removeElement($tab);
    }
}
