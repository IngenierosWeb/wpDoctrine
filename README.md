# Wordpress Doctrine Package
Allow use Doctrine to manage the database used by your installation of wordpress.

## Usage
1. Require via composer using `composer require iweb/wp-doctrine`
2. Instantiate the WpDoctrine Class, and passing how parameter an array with the paths to your entity folders `$WpDoctrine = new WpDoctrine([__DIR__.'/Entity']);`
3. Use it `$option = $WpDoctrine->entityManager->getRepository(Option::class)->find(1);`