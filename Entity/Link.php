<?php

namespace MarkerTabsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="MarkerTabsBundle\Repository\LinkRepository")
 */
class Link
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
     * @Annotation\Groups({"link"})
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @Annotation\Groups({"link"})
     * @ORM\Column(name="url", type="string")
     */
    private $url;

    /**
     * @var string
     *
     * @Annotation\Groups({"link"})
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     * @var string
     *
     * @Annotation\Groups({"link"})
     * @ORM\Column(name="bgcolor", type="string", length=7)
     */
    private $bgcolor;

    /**
     * @var string
     *
     * @Annotation\Groups({"link"})
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
     * @Annotation\Groups({"link_extra", "link_tab"})
     * @ORM\ManyToOne(targetEntity="Tab", inversedBy="links")
     * @ORM\JoinColumn(name="tab_id", referencedColumnName="id")
     */
    private $tab;


    /**
     * Constructor
     */
    public function __construct()
	{
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
     * @return Link
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
     * Set url
     *
     * @param string $url
     *
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url= $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Link
     */
    public function setImage($image)
    {
        $this->image= $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set bgcolor
     *
     * @param string $bgcolor
     *
     * @return Link
     */
    public function setBgcolor($bgcolor)
    {
        $this->bgcolor= $bgcolor;

        return $this;
    }

    /**
     * Get bgcolor
     *
     * @return string
     */
    public function getBgcolor()
    {
        return $this->bgcolor;
    }

    /**
     * Set order
     *
     * @param int $order
     *
     * @return Link
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
     * @return Link
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
     * Set tab
     *
     * @param \MarkerTabsBundle\Entity\Tab $tab
     *
     * @return Link
     */
    public function setTab(\MarkerTabsBundle\Entity\Tab $tab = null)
	{
        $this->tab = $tab;
        return $this;
    }

    /**
     * Get tab
     *
     * @return \MarkerTabsBundle\Entity\Tab
     */
    public function getTab()
	{
        return $this->tab;
    }
}
