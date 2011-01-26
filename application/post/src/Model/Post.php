<?php
/**
 * Epixa - Forum
 */

namespace Post\Model;

use Epixa\Model\AbstractModel,
    User\Model\User,
    DateTime,
    LogicException;

/**
 * @category   Module
 * @package    Post
 * @subpackage Model
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity(repositoryClass="Post\Repository\Post")
 * @Table(name="post")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discriminator", type="string")
 * @DiscriminatorMap({
 *   "standard" = "Post\Model\Post", 
 *   "link"     = "Post\Model\Post\Link"
 * })
 *
 * @property-read integer  $id
 * @property-read string   $type
 * @property-read DateTime $dateCreated
 * 
 * @property string   $title
 * @property string   $description
 * @property User     $createdBy
 * @property DateTime $dateUpdated
 * @property User     $updatedBy
 */
class Post extends AbstractModel
{
    /**
     * @var string
     */
    protected $type = 'standard';
    
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * @Column(name="title", type="string")
     * 
     * @var string
     */
    protected $title;
    
    /**
     * @Column(name="description", type="string", nullable="true")
     * 
     * @var null|string
     */
    protected $description = null;
    
    /**
     * @Column(name="date_created", type="datetime")
     * 
     * @var DateTime
     */
    protected $dateCreated;
    
    /**
     * @ManyToOne(targetEntity="User\Model\User")
     * @JoinColumn(name="created_by_user_id", referencedColumnName="id")
     * 
     * @var User
     */
    protected $createdBy;
    
    /**
     * @Column(name="date_updated", type="datetime", nullable="true")
     * 
     * @var null|DateTime
     */
    protected $dateUpdated = null;
    
    /**
     * @ManyToOne(targetEntity="User\Model\User")
     * @JoinColumn(name="updated_by_user_id", referencedColumnName="id")
     * 
     * @var null|User
     */
    protected $updatedBy = null;
    
    
    /**
     * Construct a new post
     * 
     * Set the post title, date created, and the user that created the post.
     * 
     * @param string $title
     * @param User   $createdBy
     */
    public function __construct($title, User $createdBy)
    {
        $this->assertType();
        
        $this->setTitle($title);
        $this->setCreatedBy($createdBy);
        $this->dateCreated = new DateTime('now');
    }
    
    /**
     * Invoked when object is unserialized
     * 
     * Assert that the object has a type specified
     */
    public function __wakeup()
    {
        $this->assertType();
    }
    
    /**
     * Assert that we have a type specified
     */
    public function assertType()
    {
        if (null === $this->type) {
            throw new LogicException('No post type was specified');
        }
    }
    
    /**
     * Throws exception so id cannot be set directly
     *
     * @param  integer $id
     * @throws LogicException
     */
    public function setId($id)
    {
        throw new LogicException('Cannot set id directly');
    }
    
    /**
     * Set the title of this post
     * 
     * @param  string $title
     * @return AbstractPost *Fluent interface*
     */
    public function setTitle($title)
    {
        $this->title = (string)$title;
        
        return $this;
    }
    
    /**
     * Get the title of this post
     * 
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set the user that created this post
     *
     * @param  User $user
     * @return AbstractPost *Fluent interface*
     */
    public function setCreatedBy(User $user)
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * Get the user that created this post
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Throws exception so creation date cannot be set directly
     * 
     * @param  mixed $data
     * @throws LogicException
     */
    public function setDateCreated($date)
    {
        throw new LogicException('Cannot set creation date directly');
    }
    
    /**
     * Get the date this post was created
     *
     * @return DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    
    /**
     * Set the user that last updated this post
     *
     * @param  User $user
     * @return AbstractPost *Fluent interface*
     */
    public function setUpdatedBy(User $user)
    {
        $this->updatedBy = $user;

        return $this;
    }

    /**
     * Get the user that created this post
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    /**
     * Set the date this post was last updated
     * 
     * @param  DateTime $date
     * @return AbstractPost *Fluent interface*
     */
    public function setDateUpdated(DateTime $date)
    {
        $this->dateUpdated = $date;
        
        return $this;
    }
    
    /**
     * Get the date this post was last updated
     *
     * @return null|DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
    
    /**
     * Throws exception so type cannot be set directly
     *
     * @param  integer $type
     * @throws LogicException
     */
    public function setType($type)
    {
        throw new LogicException('Cannot set type directly');
    }
}