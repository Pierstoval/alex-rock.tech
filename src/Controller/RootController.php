<?php

declare(strict_types=1);

/*
 * This file is part of the piers.tech package.
 *
 * (c) Alex "Pierstoval" Rock <alex@piers.tech>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RootController
{
    private array $locales;

    public function __construct(array $locales)
    {
        $this->locales = $locales;
    }

    public function __invoke(Request $request): RedirectResponse
    {
        $locale = $request->getPreferredLanguage($this->locales);

        $locale = 'en'; // FIXME ASAP

        $url = \rtrim($request->getPathInfo(), '/').'/'.$locale;

        return new RedirectResponse($url);
    }
}
