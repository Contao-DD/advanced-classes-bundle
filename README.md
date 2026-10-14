Contao Advanced Classes
======================

[![Latest Stable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/stable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Total Downloads](https://poser.pugx.org/contao-dd/advanced-classes-bundle/downloads)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![Latest Unstable Version](https://poser.pugx.org/contao-dd/advanced-classes-bundle/v/unstable)](https://packagist.org/packages/contao-dd/advanced-classes-bundle) [![License](https://poser.pugx.org/contao-dd/advanced-classes-bundle/license)](https://packagist.org/packages/contao-dd/advanced-classes-bundle)

Das Modul erweitert die CSS-Klassen der Contao-Inhaltselemente und Formularfelder durch selbst definierbare Sets an CSS-Klassen. Redakteure und Admins können über Select-Felder schnell auf vordefinierte CSS-Klassen zugreifen.

Für [Bootstrap 4 und 5](https://getbootstrap.com/), [Materialize](https://materializecss.com/), [Bulma](https://bulma.io/) und [Spectre.css](https://picturepan2.github.io/spectre/) wird bereits ein vordefiniertes Set für Spaltenbreite, Spalten-Offset, Reihenfolge und Sichtbarkeit mitgeliefert.


About
-----

Extend the CSS classes of Contao content elements and form fields with predefined sets of CSS classes. Editors and admins can pick the classes via select fields.

Predefined sets for column width, offset, order and visibility are included for [Bootstrap 4 and 5](https://getbootstrap.com/), [Materialize](https://materializecss.com/), [Bulma](https://bulma.io/) and [Spectre.css](https://picturepan2.github.io/spectre/).

**Supported Entities**
All content elements with CSS settings (including content elements of news and events) and form fields.


Screenshots
-----------

![Setting classes for bootstrap](https://pdir.de/contao-dd/advanced-classes-screenshot1-contao4.png)
![Local settings](https://pdir.de/contao-dd/advanced-classes-screenshot2-contao4.png)


Systemvoraussetzungen / System requirements
-------------------

* [Contao](https://github.com/contao/contao) 5.3 or 6
* PHP 8.1 or higher (Contao 6 requires PHP 8.4)

Für Contao 4 nutze bitte Version 1.6 / For Contao 4 please use version 1.6.


Installation & Configuration
----------------------------

DE:

* Installiere die Erweiterung über den Contao Manager oder mit `composer require contao-dd/advanced-classes-bundle`
* Aktualisiere die Datenbank
* Wähle das CSS-Klassen-Set in deiner Website-Startseite (für Inhaltselemente) bzw. im Formular (für Formularfelder) aus
* Setze die gewünschten Klassen in den Elementen

EN:

* Install the extension via the Contao Manager or with `composer require contao-dd/advanced-classes-bundle`
* Update your database
* Select the CSS class set in the root page settings (for content elements) or in the form settings (for form fields)
* Set the classes of every element you wish


Upgrade
-------

DE: Die Sets für Bootstrap 2, Bootstrap 3 und Bootstrap 4 alpha wurden entfernt. Startseiten und Formulare, die eines dieser Sets nutzen, werden beim Aktualisieren der Datenbank auf „kein Set“ zurückgesetzt. Wer ein entferntes Set weiter braucht, kann es aus einer älteren Version kopieren und als eigenes Set registrieren (siehe unten).

EN: The Bootstrap 2, Bootstrap 3 and Bootstrap 4 alpha sets have been removed. Root pages and forms using one of these sets are reset to "no set" when updating the database. If you still need a removed set, copy it from an older version and register it as a custom set (see below).


Eigenes Set / Custom Set
----------------------------

DE:

* Lege eine JSON-Datei an ([Beispiel](https://github.com/Contao-DD/advanced-classes-bundle/blob/master/public/sets/bootstrap5.json)) und lege sie z. B. im files-Ordner ab
* Lege folgende Datei an oder bearbeite sie: **contao/config/config.php**
* Füge in der config.php folgendes ein, um das Set zu registrieren. Anschließend muss der Cache im Contao Manager geleert werden.

```php
<?php

$GLOBALS['customAdvancedClassesSets'][] = '/files/sets/custom-set.json';
```

* Danach kann das Set in den Einstellungen ausgewählt werden.

EN:

* Create a JSON file ([Example](https://github.com/Contao-DD/advanced-classes-bundle/blob/master/public/sets/bootstrap5.json)), e.g. in the files directory
* Create or edit the following file: **contao/config/config.php**
* Add this code to the config.php to register the set. Then clear the cache in the Contao Manager.

```php
<?php

$GLOBALS['customAdvancedClassesSets'][] = '/files/sets/custom-set.json';
```

* Now you can choose the set in the settings.


License
---------------
LGPL-3.0-or-later
