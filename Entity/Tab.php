<?php

namespace MarkerTabsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tab
 *
 * @ORM\Table(name="tab")
 * @ORM\Entity(repositoryClass="MarkerTabsBundle\Repository\TabRepository")
 */
class Tab
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
     * @Annotation\Groups({"tab"})
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @Annotation\Groups({"tab"})
     * @ORM\Column(name="cols", type="integer")
     */
    private $cols;

    /**
     * @var string
     *
     * @Annotation\Groups({"tab"})
     * @ORM\Column(name="order", type="integer")
     */
    private $order;

    /**
     * @var string
     *
     * @Annotation\Groups({"link"})
     * @ORM\Column(name="hidden", type="boolean")
     */
    private $hidden;

    /**
     * @Annotation\Groups({"tab_extra", "tab_links"})
     * @ORM\OneToMany(targetEntity="Link", mappedBy="tab")
     */
    private $links;

    /**
     * @Annotation\Groups({"tab_extra", "tab_user"})
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tabs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    /**
     * Constructor
     */
    public function __construct()
	{
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Tab
     */
    public function setName($name)
    {
        $this->name= $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set cols
     *
     * @param int $cols
     *
     * @return Tab
     */
    public function setCols($cols)
    {
        $this->cols= $cols;

        return $this;
    }

    /**
     * Get cols
     *
     * @return int
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * Set order
     *
     * @param int $order
     *
     * @return Tab
     */
    public function setOrder($order)
    {
        $this->order= $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return Tab
     */
    public function setHidden($hidden)
    {
        $this->hidden= $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Add link
     *
     * @param \MarkerTabsBundle\Entity\Link $link
     *
     * @return Tab
     */
    public function addLink(\MarkerTabsBundle\Entity\Link $link)
	{
        $this->links[] = $link;
        return $this;
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLinks()
	{
        return $this->links;
    }

    /**
     * Remove link
     *
     * @param \MarkerTabsBundle\Entity\Link $link
     */
    public function removeLink(\MarkerTabsBundle\Entity\Link $link)
	{
        $this->links->removeElement($link);
    }

    /**
     * Set user
     *
     * @param \MarkerTabsBundle\Entity\User $user
     *
     * @return Tab
     */
    public function setUser(\MarkerTabsBundle\Entity\User $user= null)
	{
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return \MarkerTabsBundle\Entity\Tab
     */
    public function getUser()
	{
        return $this->user;
    }
}
