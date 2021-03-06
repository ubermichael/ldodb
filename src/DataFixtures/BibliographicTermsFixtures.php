<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\DataFixtures;

use App\Entity\BibliographicTerms;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BibliographicTermsFixtures extends Fixture {
    public function load(ObjectManager $em) : void {
        $object = new BibliographicTerms();
        $object->setBibliographicTerm('fins');
        $object->setUseForFormat(true);
        $object->setUseForIllustrations(true);
        $object->setUseForPhotographs(true);
        $em->persist($object);
        $em->flush();
        $this->setReference('BibliographicTerms.1', $object);
    }
}
