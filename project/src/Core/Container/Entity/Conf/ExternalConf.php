<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 14:26
 */

namespace Core\Container\Entity\Conf;


use Core\Container\Entity\PropertyAccessInterface;

class ExternalConf implements PropertyAccessInterface
{

    private $database_host;
    private $database_port;
    private $database_name;
    private $database_user;
    private $database_password;
    private $mailer_transport;
    private $mailer_host;
    private $mailer_user;
    private $mailer_password;
    private $mailer_port;
    private $mailer_encryption;
    private $mailer_dev_email;
    private $elastic_port;
    private $elastic_host;
    private $secret;

    public function getProperties(): array
    {
        return [
            'database_host',
            'database_port',
            'database_name',
            'database_user',
            'database_password',
            'mailer_transport',
            'mailer_host',
            'mailer_user',
            'mailer_password',
            'mailer_port',
            'mailer_encryption',
            'mailer_dev_email',
            'elastic_port',
            'elastic_host',
            'secret',
        ];
    }

    /**
     * @return mixed
     */
    public function getDatabaseHost()
    {
        return $this->database_host;
    }

    /**
     * @param mixed $database_host
     */
    public function setDatabaseHost($database_host): void
    {
        $this->database_host = $database_host;
    }

    /**
     * @return mixed
     */
    public function getDatabasePort()
    {
        return $this->database_port;
    }

    /**
     * @param mixed $database_port
     */
    public function setDatabasePort($database_port): void
    {
        $this->database_port = $database_port;
    }

    /**
     * @return mixed
     */
    public function getDatabaseName()
    {
        return $this->database_name;
    }

    /**
     * @param mixed $database_name
     */
    public function setDatabaseName($database_name): void
    {
        $this->database_name = $database_name;
    }

    /**
     * @return mixed
     */
    public function getDatabaseUser()
    {
        return $this->database_user;
    }

    /**
     * @param mixed $database_user
     */
    public function setDatabaseUser($database_user): void
    {
        $this->database_user = $database_user;
    }

    /**
     * @return mixed
     */
    public function getDatabasePassword()
    {
        return $this->database_password;
    }

    /**
     * @param mixed $database_password
     */
    public function setDatabasePassword($database_password): void
    {
        $this->database_password = $database_password;
    }

    /**
     * @return mixed
     */
    public function getMailerTransport()
    {
        return $this->mailer_transport;
    }

    /**
     * @param mixed $mailer_transport
     */
    public function setMailerTransport($mailer_transport): void
    {
        $this->mailer_transport = $mailer_transport;
    }

    /**
     * @return mixed
     */
    public function getMailerHost()
    {
        return $this->mailer_host;
    }

    /**
     * @param mixed $mailer_host
     */
    public function setMailerHost($mailer_host): void
    {
        $this->mailer_host = $mailer_host;
    }

    /**
     * @return mixed
     */
    public function getMailerUser()
    {
        return $this->mailer_user;
    }

    /**
     * @param mixed $mailer_user
     */
    public function setMailerUser($mailer_user): void
    {
        $this->mailer_user = $mailer_user;
    }

    /**
     * @return mixed
     */
    public function getMailerPassword()
    {
        return $this->mailer_password;
    }

    /**
     * @param mixed $mailer_password
     */
    public function setMailerPassword($mailer_password): void
    {
        $this->mailer_password = $mailer_password;
    }

    /**
     * @return mixed
     */
    public function getMailerPort()
    {
        return $this->mailer_port;
    }

    /**
     * @param mixed $mailer_port
     */
    public function setMailerPort($mailer_port): void
    {
        $this->mailer_port = $mailer_port;
    }

    /**
     * @return mixed
     */
    public function getMailerEncryption()
    {
        return $this->mailer_encryption;
    }

    /**
     * @param mixed $mailer_encryption
     */
    public function setMailerEncryption($mailer_encryption): void
    {
        $this->mailer_encryption = $mailer_encryption;
    }

    /**
     * @return mixed
     */
    public function getMailerDevEmail()
    {
        return $this->mailer_dev_email;
    }

    /**
     * @param mixed $mailer_dev_email
     */
    public function setMailerDevEmail($mailer_dev_email): void
    {
        $this->mailer_dev_email = $mailer_dev_email;
    }

    /**
     * @return mixed
     */
    public function getElasticPort()
    {
        return $this->elastic_port;
    }

    /**
     * @param mixed $elastic_port
     */
    public function setElasticPort($elastic_port): void
    {
        $this->elastic_port = $elastic_port;
    }

    /**
     * @return mixed
     */
    public function getElasticHost()
    {
        return $this->elastic_host;
    }

    /**
     * @param mixed $elastic_host
     */
    public function setElasticHost($elastic_host): void
    {
        $this->elastic_host = $elastic_host;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret): void
    {
        $this->secret = $secret;
    }


}