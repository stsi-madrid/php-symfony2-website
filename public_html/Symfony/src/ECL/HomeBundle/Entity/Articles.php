<?php
namespace ECL\HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ECL\HomeBundle\Entity\Articles
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="ECL\HomeBundle\Entity\ArticlesRepository")
 */
class Articles
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(type="string", length=400)
     */
    private $title;
    
    /**
     * @var string $uri
     *
     * @ORM\Column(type="string", length=400)
     */
    private $uri;
    
    /**
     * @var string $summary
     *
     * @ORM\Column(type="string", length=3000)
     */
    private $summary;
    
    /**
     * @var datetime $date
     * 
     * @ORM\Column(type="datetime")
     */
    private $date;
    
    /**
     * @var string $user_id
     *
     * @ORM\Column(type="integer")
     */
    private $user_id;    
    
    /**
     * @ORM\OneToOne(targetEntity="ArticlesExtend", mappedBy="article")
     */
    private $articles_extend;
    
    public function __construct()
    {
        $this->date = new \DateTime ();
    }    
    
    public function setArticlesExtend(ArticlesExtend $articles_extend)
    {
        $this->articles_extend = $articles_extend;
    }

    public function getArticlesExtend()
    {
        return $this->articles_extend;
    }
    
    /* Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

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
     * @param string $articleTitle
     */
    public function setArticleTitle($articleTitle)
    {
        $this->title = $articleTitle;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getArticleTitle()
    {
        return $this->title;
    }
    
    /**
     * Set uri
     *
     * @param string $articleUri
     */
    public function setArticleUri($articleUri)
    {
        $this->uri = $articleUri;
    }

    /**
     * Get uri
     *
     * @return string 
     */
    public function getArticleUri()
    {
        return $this->uri;
    }
    
    /**
     * Set summary
     *
     * @param string $articleSummary
     */
    public function setArticleSummary($articleSummary)
    {
        $this->summary = $articleSummary;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getArticleSummary()
    {
        return $this->summary;
    }
    
    /**
     * Set date
     *
     * @param datetime $articleDate
     */
    public function setArticleDate($articleDate)
    {
        $this->date = $articleDate;
    }

    /**
     * Get date
     *
     * @return datetime 
     */
    public function getArticleDate()
    {
        return $this->date;
    }
    
    /* Set user_id
     *
     * @param integer $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }
    
}
