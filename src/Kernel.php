<?php

namespace App;

/***
 * C'est la class noyau de symfony pour faire des configurations spécifiques de la classe Kernel
 */

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
