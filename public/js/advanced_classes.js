(function () {
    'use strict';

    var CONTAINER_ID = 'advancedFormContainer';
    var EMPTY = '-';

    function tokenize(value) {
        return (value || '').split(/\s+/).filter(Boolean);
    }

    function el(tag, attrs, text) {
        var node = document.createElement(tag);

        Object.keys(attrs || {}).forEach(function (name) {
            node.setAttribute(name, attrs[name]);
        });

        if (undefined !== text) {
            node.textContent = text;
        }

        return node;
    }

    function findRoot() {
        return document.querySelector('[data-contao--toggle-fieldset-id-value="advanced_classes_legend"]')
            || document.getElementById('pal_advanced_classes_legend');
    }

    function buildForm(root, json, config) {
        var container = el('div', { id: CONTAINER_ID });
        var selects = [];

        root.appendChild(container);

        Object.keys(json.sections || {}).forEach(function (sectionKey) {
            var section = json.sections[sectionKey];
            var headline = el('h3', { class: section.secClass || '' });
            var sectionContainer = el('div', { id: section.secId || '' });

            headline.appendChild(el('label', {}, section.secHeadline || ''));
            container.appendChild(headline);
            container.appendChild(sectionContainer);

            Object.keys(section.cssSet || {}).forEach(function (setKey) {
                var set = section.cssSet[setKey];

                // @todo add other types if needed
                if ('select' !== set.type) {
                    return;
                }

                var hasLabel = undefined !== set.label;
                var selectId = 'advanced-form-' + set.id;
                var wrapper = el('div', {
                    class: 'value ' + (set.class || '') + (hasLabel ? ' with-label' : '') + ' select',
                    for: selectId,
                });
                var select = el('select', { id: selectId, name: selectId, class: 'tl_select tl_chosen' });

                if (hasLabel) {
                    wrapper.appendChild(el('label', { for: selectId }, set.label));
                }

                select.appendChild(el('option', { value: EMPTY }, EMPTY));

                Object.keys(set.values || {}).forEach(function (valueKey) {
                    var option = set.values[valueKey];
                    select.appendChild(el('option', { value: option.value }, option.title));
                });

                // Preselect the 12th option (full width) of the first column select
                if ('1' === String(config.defaultColumnWidth) && 'columnSetSizeSelect1' === set.id && select.options.length > 12) {
                    select.selectedIndex = 12;
                }

                wrapper.appendChild(select);
                sectionContainer.appendChild(wrapper);
                selects.push(select);
            });
        });

        return selects;
    }

    // Select the options whose classes are present; the most specific options claim their classes first,
    // so a class like "d-none" is only assigned to one select
    function setSelectsFromInput(selects, input) {
        var current = tokenize(input.value);
        var candidates = [];
        var claimed = [];
        var assigned = new Set();

        selects.forEach(function (select, index) {
            Array.prototype.forEach.call(select.options, function (option) {
                var tokens = tokenize(option.value);

                if (EMPTY !== option.value && tokens.every(function (token) { return -1 !== current.indexOf(token); })) {
                    candidates.push({ select: select, index: index, value: option.value, tokens: tokens });
                }
            });
        });

        candidates.sort(function (a, b) {
            return b.tokens.length - a.tokens.length || a.index - b.index;
        });

        candidates.forEach(function (candidate) {
            if (assigned.has(candidate.select) || candidate.tokens.some(function (token) { return -1 !== claimed.indexOf(token); })) {
                return;
            }

            candidate.select.value = candidate.value;
            assigned.add(candidate.select);
            claimed = claimed.concat(candidate.tokens);
        });
    }

    function bindChange(selects, input) {
        var previous = new Map();

        selects.forEach(function (select) {
            // Only track values that are really part of the input; a preselected default is not
            var tokens = tokenize(select.value);
            var current = tokenize(input.value);
            var isApplied = EMPTY !== select.value && tokens.every(function (token) { return -1 !== current.indexOf(token); });

            previous.set(select, isApplied ? select.value : EMPTY);

            select.addEventListener('change', function () {
                var classes = tokenize(input.value);

                // Classes still used by other selects must not be removed
                var protectedTokens = [];
                selects.forEach(function (other) {
                    if (other !== select && EMPTY !== previous.get(other)) {
                        protectedTokens = protectedTokens.concat(tokenize(previous.get(other)));
                    }
                });

                var remove = tokenize(previous.get(select)).filter(function (token) {
                    return -1 === protectedTokens.indexOf(token);
                });

                classes = classes.filter(function (token) {
                    return -1 === remove.indexOf(token);
                });

                if (EMPTY !== select.value) {
                    tokenize(select.value).forEach(function (token) {
                        if (-1 === classes.indexOf(token)) {
                            classes.push(token);
                        }
                    });
                }

                input.value = classes.join(' ');
                input.dispatchEvent(new Event('change', { bubbles: true }));
                previous.set(select, select.value);
            });
        });
    }

    function init() {
        var input = document.getElementById('ctrl_advancedCss');
        var configNode = document.querySelector('[data-advanced-classes-set]');
        var root = findRoot();

        if (!input || !configNode || !root || document.getElementById(CONTAINER_ID)) {
            return;
        }

        var config = {
            set: configNode.getAttribute('data-advanced-classes-set'),
            defaultColumnWidth: configNode.getAttribute('data-advanced-classes-default-column-width'),
        };

        if (!config.set) {
            return;
        }

        fetch(config.set, { credentials: 'same-origin' })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }

                return response.json();
            })
            .then(function (json) {
                // The page may have changed while loading (Turbo)
                if (!document.body.contains(root) || document.getElementById(CONTAINER_ID)) {
                    return;
                }

                var selects = buildForm(root, json, config);

                setSelectsFromInput(selects, input);
                bindChange(selects, input);

                // Hide the plain text widget, the selects replace it
                var widget = root.querySelector(':scope > div');
                if (widget && widget.id !== CONTAINER_ID) {
                    widget.style.display = 'none';
                }
            })
            .catch(function (error) {
                console.error('[advanced-classes] Could not load set "' + config.set + '":', error);
            });
    }

    window.AdvancedClasses = { init: init };

    if ('undefined' !== typeof Turbo) {
        document.addEventListener('turbo:load', init);
    } else if ('loading' === document.readyState) {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
