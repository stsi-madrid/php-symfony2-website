<?php
namespace ECL\HomeBundle\Entity;

use ECL\HomeBundle\Entity\Articles;
use Doctrine\ORM\Mapping as ORM;

/**
 * ECL\HomeBundle\Entity\ArticlesExtend
 *
 * @ORM\Table(name="news_extend")
 * @ORM\Entity(repositoryClass="ECL\HomeBundle\Entity\ArticlesExtendRepository")
 */
class ArticlesExtend
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $text
     *
     * @ORM\Column(name="text", type="string", length=5000)
     */
    private $text;
    
   /**
     * @ORM\OneToOne(targetEntity="Articles", inversedBy="articles_extend")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", onDelete="CASCADE")
     * @return integer
     */
    private $article;
    
    public function setArticle(Articles $article)
    {
        $this->article = $article;
    }

    public function getArticle()
    {
        return $this->article;
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
     * Set text
     *
     * @param string $articleText
     */
    public function setArticleText($articleText)
    {
        $this->text = $articleText;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getArticleText()
    {
        return $this->text;
    }
    
}
