<?php
namespace ECL\HomeBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticlesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticlesRepository extends EntityRepository
{
    public function getTotalArticlesNum()
    {
        $dql = 'select count(a.id) from ECLHomeBundle:Articles a';
        $query = $this->getEntityManager()->createQuery($dql);
        
        return (int) $query->getSingleScalarResult();
    }
    
    public function getDateByUri($uri)
    {
        $dql = 'select a.date
        from ECLHomeBundle:Articles a
        where a.uri=:uri';
        
        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array ('uri' => $uri))
            ->getSingleScalarResult();
    }

    public function getFullArticle($date, $uri)
    {
        list ($day, $month, $year) = explode ('-', $date);
        $alter_date = $year.'-'.$month.'-'.$day.' 00:00:00';
        $dql = 'select a.id, a.title, a.summary, a.date, ae.text
        from ECLHomeBundle:ArticlesExtend ae
        join ae.article a
        where a.uri=:uri AND
        DATE_DIFF(a.date, :date) = 0';
        
        return $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameters(array ('uri' => $uri, 'date' => $alter_date))
            ->getSingleResult();
    }
    
    public function getArticles($limit = null, $page = null, $user_id = null)
    {
        $dql = 'select a.id, a.title, a.uri, a.date,
        a.summary from ECLHomeBundle:Articles a';
        if ($user_id !== null) {
            $dql .= ' where a.user_id = '.$user_id;
        }
        $dql .= ' order by a.id DESC';
        $em = $this->getEntityManager();
        $query = $em->createQuery($dql);
        if ($limit !== null) {
            $query->setMaxResults($limit);
        }        
        if ($page !== null) {
            $query->setFirstResult(($page-1)*$limit);
        }

        return $query->getResult();
    }
    
}
