<?php
/**
 * Created by JetBrains PhpStorm.
 * User: amalyuhin
 * Date: 18.09.13
 * Time: 15:43
 * To change this template use File | Settings | File Templates.
 */

namespace Wealthbot\SignatureBundle\Model;


use Wealthbot\SignatureBundle\Exception\InvalidRecipientTypeException;
use Wealthbot\SignatureBundle\Model\Tab\AbstractTab;

class Recipient implements RecipientInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $roleName;

    /**
     * @var int
     */
    private $clientUserId;

    /**
     * @var TabCollection
     */
    private $tabs;

    /**
     * @var $type
     */
    private $type;

    const TYPE_SIGNER = 'signer';
    const TYPE_AGENT = 'agent';
    const TYPE_EDITOR = 'editor';
    const TYPE_CARBON_COPY = 'carbonCopy';
    const TYPE_CERTIFIED_DELIVERY = 'certifiedDelivery';
    const TYPE_IN_PERSON_SIGNER = 'InPersonSigner';

    private static $_types = null;


    public function __construct()
    {
        $this->tabs = new TabCollection();
    }

    /**
     * Set recipient email
     *
     * @param string $email
     * @return mixed|void
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * Get recipient email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set recipient name
     *
     * @param string $name
     * @return mixed
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get recipient name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set recipient role name
     *
     * @param string $roleName
     * @return mixed
     */
    public function setRoleName($roleName)
    {
        $this->roleName = $roleName;
    }

    /**
     * Get recipient role name
     *
     * @return string
     */
    public function getRoleName()
    {
        return $this->roleName;
    }

    /**
     * Set recipient client user id
     *
     * @param int $clientUserId
     * @return mixed
     */
    public function setClientUserId($clientUserId)
    {
        $this->clientUserId = $clientUserId;
    }

    /**
     * Get recipient client user id
     *
     * @return int
     */
    public function getClientUserId()
    {
        return $this->clientUserId;
    }

    /**
     * Get type choices for recipients
     *
     * @return array|null
     */
    public static function getTypeChoices()
    {
        if (null == self::$_types) {
            self::$_types = array();

            $rClass = new \ReflectionClass('Wealthbot\SignatureBundle\Model\Recipient');
            $prefix = 'TYPE_';

            foreach ($rClass->getConstants() as $key => $value) {
                if (substr($key, 0, strlen($prefix)) === $prefix) {
                    self::$_types[$value] = $value;
                }
            }
        }

        return self::$_types;
    }

    /**
     * Set recipient type
     *
     * @param string $type
     * @return mixed|void
     * @throws InvalidRecipientTypeException
     */
    public function setType($type)
    {
        if (!in_array($type, self::getTypeChoices())) {
            throw new InvalidRecipientTypeException(sprintf('Invalid recipient type: %s', $type));
        }

        $this->type = $type;
    }

    /**
     * Get recipient type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param \Wealthbot\SignatureBundle\Model\TabCollection $tabs
     */
    public function setTabs(TabCollection $tabs)
    {
        $this->tabs = $tabs;
    }

    public function addTab(AbstractTab $tab)
    {
        $this->tabs->addTab($tab);
    }

    public function removeTab(AbstractTab $tab)
    {
        return $this->tabs->removeTab($tab);
    }

    /**
     * @return \Wealthbot\SignatureBundle\Model\TabCollection
     */
    public function getTabs()
    {
        return $this->tabs;
    }
}