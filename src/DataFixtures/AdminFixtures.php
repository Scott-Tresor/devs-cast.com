<?php

/**
 * This file is part of the DevsCast project
 *
 * (c) bernard-ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminFixtures
 * @package App\DataFixtures
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AdminFixtures extends Fixture
{

    private UserPasswordEncoderInterface $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function load(ObjectManager $manager)
    {
        $defaultUser = $manager
            ->getRepository(User::class)
            ->findOneBy(['email' => "admin@devs-cast.com"]);

        if (!$defaultUser) {
            $user = new User();
            $user
                ->setName('admin')
                ->setEmail('admin@devs-cast.com')
                ->setPassword($this->encoder->encodePassword($user, $_ENV['APP_DEFAULT_PASSWORD']))
                ->setCreatedAt(new \DateTime('now'))
                ->setIsArchived(0)
                ->setRoles(['ROLE_ADMIN']);
            $manager->persist($user);
            $manager->flush();
        }
    }
}
