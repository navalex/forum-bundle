<?php

namespace Navalex\ForumBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="navalex_forum__category")
 * @ORM\Entity(repositoryClass="Navalex\ForumBundle\Repository\CategoryRepository")
 */
class Category
{
	/**
	 * @var int
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="title", type="string", length=255, unique=true)
	 */
	private $title;

	/**
	 * @Gedmo\Slug(fields={"title"})
	 * @ORM\Column(length=255, unique=true)
	 */
	private $slug;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text", nullable=true)
	 */
	private $description;

	/**
	 * @ORM\OneToMany(targetEntity="Navalex\ForumBundle\Entity\Forum", mappedBy="category")
	 */
	private $forums;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->forums = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add forum
     *
     * @param \Navalex\ForumBundle\Entity\Forum $forum
     *
     * @return Category
     */
    public function addForum(\Navalex\ForumBundle\Entity\Forum $forum)
    {
        $this->forums[] = $forum;

        return $this;
    }

    /**
     * Remove forum
     *
     * @param \Navalex\ForumBundle\Entity\Forum $forum
     */
    public function removeForum(\Navalex\ForumBundle\Entity\Forum $forum)
    {
        $this->forums->removeElement($forum);
    }

    /**
     * Get forums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getForums()
    {
        return $this->forums;
    }
}
