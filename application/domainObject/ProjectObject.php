<?php namespace Application\DomainObject;

use \System\Core\DomainObjectAbstract;

class ProjectObject extends DomainObjectAbstract
{
	private $title;
	private $slug;
	private $description;
	private $picture;
	private $author;

	public function getTitle()
	{
		return $this->title;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getPicture()
	{
		return $this->picture;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;
	}

	public function setDescription($description)
	{
		$this->description = $description;
	}

	public function setPicture($picture)
	{
		$this->picture = $picture;
	}

	public function setAuthor($author)
	{
		$this->author = $author;
	}
}