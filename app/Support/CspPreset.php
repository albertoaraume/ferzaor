<?php

namespace App\Support;

use Spatie\Csp\Directive;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;
use Spatie\Csp\Keyword;

class CspPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            // base
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::BASE, Keyword::SELF)

            // assets y XHR
            ->add(Directive::SCRIPT, Keyword::SELF)
            ->add(Directive::STYLE, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::IMG, [Keyword::SELF, 'https://mi-bucket-s3.s3.amazonaws.com'])
            ->add(Directive::FONT, [Keyword::SELF, 'https://fonts.gstatic.com'])
            ->add(Directive::FRAME_ANCESTORS, Keyword::SELF)

            // nonces para inline críticos
            ->addNonce(Directive::SCRIPT)
            ->addNonce(Directive::STYLE);
     
    }
}


