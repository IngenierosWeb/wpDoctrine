<?php
declare(strict_types=1);


namespace Iweb\WpDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="options")
 */
final class Option
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $option_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $option_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $option_value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $autoload;


}