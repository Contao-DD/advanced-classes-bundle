<?php

declare(strict_types=1);

/*
 * advanced-classes-bundle for Contao Open Source CMS
 *
 * Copyright (c) 2022 Contao Stammtisch Dresden
 *
 * @package advanced-classes
 * @author Mathias Arzberger <develop@pdir.de>
 * @license http://www.gnu.org/licences/lgpl-3.0.html LGPL
 */

namespace ContaoDD\AdvancedClassesBundle;

  use Symfony\Component\HttpKernel\Bundle\Bundle;

  class ContaoDDAdvancedClassesBundle extends Bundle
  {
      public function getPath(): string
      {
          return \dirname(__DIR__);
      }
  }
