Contao Advanced Classes
======================

[![Latest Stable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/stable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Total Downloads](https://poser.pugx.org/contao-dd/advanced-classes-bundle/downloads)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Latest Unstable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/unstable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![License](https://poser.pugx.org/contao-dd/advanced-classes-bundle/license)](https://packagist.org/packages/contao-dd/advanced-classes-bundle)

Das Modul erweitert die CSS-Klassen der Contao Elemente durch selbst definierbare Sets an CSS-Klassen. Redakteure und Admins können über Select-Felder schnell auf vordefinierte CSS-Klassen zugreifen.

Über unseren Konfigurator (noch in der Entwicklung) lassen sich die Sets auf einfache Weise an eure Anforderungen anpassen.

Für Bootstrap wird bereits ein vordefiniertes Set für Spaltenbreite, Spalten-Offset, Reihenfolge (Pull/Push) und Sichtbarkeit mitgeliefert.


About
-----

Extend the css classes of Contao elements.

**Supported Entities**
headline, text, list, table, accordion, slider, code, markdown, hyperlink, toplink, image, gallery, player, youtube, download, downloads, teaser, form, module 


Screenshot
-----------

![Setting classes for bootstrap](http://pdir.de/contao-dd/advanced-classes-screenshot1-contao4.png)
![Local settings](http://pdir.de/contao-dd/advanced-classes-screenshot2-contao4.png)


System requirements
-------------------

* [Contao](https://github.com/contao/standard-edition) 4 or higher

Installation & Configuration
----------------------------

* Extract the archive on your server
* Update your database
* Select CSS Class Set
* Set the extended class of every element you wish


See this Extension in the Contao Extension-Repository
---------------

https://contao.org/de/extension-list/view/contao-advanced-classes.html


License
---------------
LGPL-3.0+


History
---------------
v0.4.0
* new feature: default value for column widths
* new feature: disable module CSS
* add bootstrap sets

before
* [done] add basic elements
* [done] add select option for sets in default settings 
* [done] add great form to simple add bootstrap classes (reusable for other frameworks!!!) :) 
* [done] add active/inactive option for module to local config section
