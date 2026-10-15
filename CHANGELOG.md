# Changelog

[//]: <> (
Types of changes
    Added for new Addeds.
    Changed for changes in existing functionality.
    Deprecated for soon-to-be removed Addeds.
    Removed for now removed Addeds.
    Fixed for any bug fixes.
    Security in case of vulnerabilities.
)

## [2.0.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/2.0.0) – Unreleased

**Breaking changes**

- Contao 4 is no longer supported. Use version 1.6 for Contao 4.
- The bundle no longer loads jQuery in the backend. Extensions that relied on this have to load jQuery themselves.
- The Bootstrap 2, Bootstrap 3 and Bootstrap 4 alpha sets have been removed. Root pages and forms using one of them are reset to "no set" by a migration. If you still need one of these sets, copy it from version 1.6 and register it as a custom set.

**Changes**

- [Added] Support for Contao 6
- [Added] Advanced classes for explanation, fieldset, radio, checkbox, upload and ALTCHA form fields
- [Changed] The set selection shows the set titles instead of file paths
- [Changed] The "Bootstrap 4 Beta" set has been renamed to "Bootstrap 4"
- [Changed] The backend script has been rewritten in vanilla JavaScript
- [Changed] The advanced classes field is added to every palette with a CSS field
- [Fixed] Content elements of events now use the calendar settings instead of looking up a news entry
- [Fixed] Element groups inside news and events now resolve the correct root page
- [Fixed] Missing news, events, archives or pages no longer cause errors in the backend
- [Fixed] Advanced classes are no longer skipped when the element contains a similar class (e.g. `col-12` vs. `col-1`)
- [Fixed] Classes consisting of multiple values (e.g. `d-none d-md-block`) are now restored and replaced correctly
- [Fixed] Changing a select no longer removes an unrelated class when the text field was edited manually
- [Fixed] The advanced classes field is no longer shown twice in the downloads element
- [Fixed] The class set of root pages and forms can be reset to "none"
- [Fixed] Custom sets are no longer listed multiple times
- [Removed] The generic, unused Bootstrap set
- [Removed] The unused `TL_PERMISSIONS` entry. Access to the field is controlled via the allowed fields of user groups.
- [Security] Set labels and headlines are no longer inserted as HTML

## [1.6.3](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.6.3) – 2026-05-18

- [Fixed] Fixed advanced CSS class fields not loading correctly when Turbo is enabled in the Contao backend ([#26](https://github.com/Contao-DD/advanced-classes-bundle/issues/26))
- [Fixed] Minor alignment improvements for select fields with icons

## [1.6.2](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.6.2) – 2025-07-21

- [Changed] Added grid-related classes to the Bulma set

## [1.6.1](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.6.1) – 2024-05-28

- [Fixed] Add missing Bootstrap 5 set.

## [1.6.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.6.0) – 2024-04-29

- [Added] Bootstrap 5 set was added.
- [Added] No configuration message was added.
- [Fixed] Advanced Classes are now also available when editing multiple elements. The field has been reduced to a text field in this mode.
- [Fixed] The incorrect display of elements in element groups has been fixed.

## [1.5.4](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.5.4) – 2024-02-26

- [Fixed] Remove duplicated CSS classes
- [Fixed] Fix advanced classes for news and events content elements

## [1.5.3](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.5.3) – 2024-02-14

- [Fixed] Fix advanced classes settings for contao 5.3

## [1.5.2](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.5.2) – 2023-08-15

- [Changed] Load css files instead of scss files in the backend

## [1.5.1](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.5.1) – 2023-03-24

- [Added] Add styles for dark mode in Contao 5.1

## [1.5.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.5.0) – 2022-09-29

- [Added] Allow sets in form fields

## [1.4.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.4.0) – 2022-09-29

- [Changed] Refactor code for Contao 5
- [Changed] Set PHP 8.1 as minimum requirement
- [Changed] Set Contao 5 as minimum requirement

## [1.3.2](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.3.2) – 2021-12-14

- [fix] fix advanced classes for forms and modules

## [1.3.1](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.3.1) – 2021-05-05

- [fix] fix php 8 undefined array index errors

## [1.3.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.3.0) – 2021-03-03

- [feature] add more fields to spectre set

## [1.2.2](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.2.2) – 2020-09-28

- [fix] update scripts loading in config.php

## [1.2.1](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.2.1) – 2020-04-29

- [feature] add more fields to spectre set

## [1.2.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.2.0) – 2020-01-23

- [feature] add spectre set

## [1.1.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.1.0) – 2019-10-09

- [feature] add bulma set

## [1.0.1](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.0.1) – 2019-03-19

- [fix] fix dca for contao 4.7

## [1.0.0](https://github.com/Contao-DD/advanced-classes-bundle/tree/1.0.0) – 2019-02-08

- first stable release
