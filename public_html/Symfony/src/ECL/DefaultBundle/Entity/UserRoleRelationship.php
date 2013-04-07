<?php
namespace ECL\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_role")
 * @ORM\Entity(repositoryClass="ECL\DefaultBundle\Entity\UserRoleRelationshipRepository")
 */
class UserRoleRelationship
{
    
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    */
    protected $user_id;
    
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    */
    protected $role_id;

    /**
     * Get user_id
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set user_id
     *
     * @param integer $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * Get role_id
     *
     * @return integer
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * Set role_id
     *
     * @param integer $role_id
     */
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }
    
}
