Contao Advanced Classes
======================

[![Latest Stable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/stable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Total Downloads](https://poser.pugx.org/contao-dd/advanced-classes-bundle/downloads)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Latest Unstable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/unstable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![License](https://poser.pugx.org/contao-dd/advanced-classes-bundle/license)](https://packagist.org/packages/contao-dd/advanced-classes-bundle)

Das Modul erweitert die CSS-Klassen der Contao Elemente durch selbst definierbare Sets an CSS-Klassen. Redakteure und Admins können über Select-Felder schnell auf vordefinierte CSS-Klassen zugreifen.

Über unseren Konfigurator (noch in der Entwicklung) lassen sich die Sets auf einfache Weise an eure Anforderungen anpassen.

Für [Bootstrap](https://getbootstrap.com/), [Materialize](https://materializecss.com/), [Bulma](https://bulma.io/) und [Spectre.css](https://picturepan2.github.io/spectre/) wird bereits ein vordefiniertes Set für Spaltenbreite, Spalten-Offset, Reihenfolge (Pull/Push) und Sichtbarkeit mitgeliefert.


About
-----

Extend the css classes of Contao elements.

**Supported Entities**
headline, text, list, table, accordion, slider, code, markdown, hyperlink, toplink, image, gallery, player, youtube, download, downloads, teaser, module 


Screenshots
-----------

![Setting classes for bootstrap](http://pdir.de/contao-dd/advanced-classes-screenshot1-contao4.png)
![Local settings](http://pdir.de/contao-dd/advanced-classes-screenshot2-contao4.png)


Systemvoraussetzungen / System requirements
-------------------

* [Contao 5](https://github.com/contao/contao)
* [Contao 5 Managed Edition](https://github.com/contao/managed-edition)


Installation & Configuration
----------------------------

DE:

* Installiere die Erweiterung über den Contao Manager
* Aktualisiere die Datenbank
* Wähle das CSS-Klassen-Set in deiner Website-Startseite aus
* Setze die gewünschten Klassen in den Elementen

EN:

* Install the extension via the contao manager
* Update your database
* Select CSS Class Set in the root page settings
* Set the extended class of every element you wish


Eigenes Set / Custom Set
----------------------------

DE:

* Lege eine JSON-Datei an ([Beispiel](https://github.com/Contao-DD/advanced-classes-bundle/blob/master/src/Resources/public/sets/spectre.json)) und lege sie z. B. im files-Ordner ab
* Lege folgende Datei an oder bearbeite sie: **contao/config/config.php**
* Füge in der config.php folgendes ein um das Set zu registrieren. Anschließend muss der Cache im Contao Manager geleert werden.

```
<?php

$GLOBALS['customAdvancedClassesSets'][] = '/files/sets/custom-set.json';
```

* Danach kann das Set in den Einstellungen ausgewählt werden.

EN:

* Create a json file ([Example](https://github.com/Contao-DD/advanced-classes-bundle/blob/master/src/Resources/public/sets/spectre.json)), e.g. in the files directory
* Create the following file or edit them: **app/Resources/contao/config/config.php**
* Paste this code in the config.php to registrate the set. Than you should clear the cache in the contao manager.

```
<?php

$GLOBALS['customAdvancedClassesSets'][] = '/files/sets/custom-set.json';
```

* Now you can choose the set in the settings.


License
---------------
LGPL-3.0+
