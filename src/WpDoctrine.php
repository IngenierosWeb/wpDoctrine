<?php
declare(strict_types=1);


namespace Iweb\WpDoctrine;


use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\ToolsException;
use Iweb\WpDoctrine\DoctrineExtensions\TablePrefix;
use Iweb\WpMembership\Entity\Subscription;

/**
 * Class WpDoctrine
 * @package Iweb\WpDoctrine
 *
 * @todo listener minimize table names.
 */
final class WpDoctrine
{
    public EntityManager $entityManager;

    public function __construct(array $paths){
        global $wpdb;

//        $paths = array();
        $paths = array_merge($paths,[__DIR__."/entity"]);
        $isDevMode = true;

// the connection configuration
        $dbParams = array(
            'driver'   => 'pdo_mysql',
            'host'     => DB_HOST,
            'user'     => DB_USER,
            'password' => DB_PASSWORD,
            'dbname'   => DB_NAME,
        );

//        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
        $config = Setup::createConfiguration($isDevMode);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);


//        $this->entityManager = EntityManager::create($dbParams, $config);

// $connectionOptions and $config set earlier

        $evm = new \Doctrine\Common\EventManager;

// Table Prefix
        $tablePrefix = new TablePrefix($wpdb->prefix);
        $evm->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);

        $this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams, $config, $evm);

    }

    public function createSchema(){
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = array(
            $this->entityManager->getClassMetadata(Subscription::class),
//            $this->entityManager->getClassMetadata('Entities\Profile')
        );
        try {
            $tool->createSchema($classes);
        } catch (ToolsException $e) {
            var_dump($e->getMessage());
        }

    }

    public function dropSchema(){
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = array(
            $this->entityManager->getClassMetadata(Subscription::class),
//            $this->entityManager->getClassMetadata('Entities\Profile')
        );
        try {
            $tool->createSchema($classes);
        } catch (ToolsException $e) {
            var_dump($e->getMessage());
        }
    }

}