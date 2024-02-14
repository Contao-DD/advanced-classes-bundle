(function ($) {

    var AdvancedClasses = {
        onReady: function () {
            this.json = '';
            
            if(0 === $('#pal_advanced_classes_legend').length) {
                this.rootElem = $('[data-contao--toggle-fieldset-id-value=advanced_classes_legend]');
            } else {
                this.rootElem = $('#pal_advanced_classes_legend');
            }
            
            if($('#ctrl_advancedCss').length) {
                var sourceSet = advancedClassesSet;
                $.getJSON(sourceSet)
                    .done(function (json) {
                        AdvancedClasses.json = json;
                        AdvancedClasses.buildForm();
                        AdvancedClasses.onChangeSelectFields();
                        AdvancedClasses.setSelectFieldsFromCss();
                        AdvancedClasses.hideAdvancedCssInput();
                    }).fail(function (jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                    });
            }
        },
        buildForm: function () {
            var $dataset = this.json;
            // append form container
            var container = $("<div id='advancedFormContainer'/>");
            $(this.rootElem).append(container);

            var sections = $dataset.sections;
            Object.keys(sections).forEach(function (key) {
                var section = sections[key];
                // headline
                var headline = '<h3 class="' + section.secClass + '"><label>' + section.secHeadline + '</label></h3>';
                var advancedFormContainer = $("#advancedFormContainer");
                advancedFormContainer.append(headline);
                // set container
                var container = $("<div id='" + section.secId + "'/>");
                advancedFormContainer.append(container);

                Object.keys(section.cssSet).forEach(function (setKey) {
                    var value =section.cssSet[setKey];
                    // select
                    if (value.type == 'select') {
                        var label = "";
                        if(typeof value.label !== "undefined") {
                            label = '<label>' + value.label + '</label>';
                        }
                        var select = '<div class="value ' + value.class + ' ' + value.type + '" for="advanced-form-' + value.id + '">' + label + '<select id="advanced-form-' + value.id + '" name="advanced-form-' + value.id + '" class="tl_select tl_chosen"><option>-</option></option></select></div>';
                        $("#" + section.secId).append(select);
                        var i = 1;
                        Object.keys(value.values).forEach(function (optKey) {
                            AdvancedClasses.formHelperGetOption(value.values[optKey], "#advanced-form-" + value.id);

                            if(defaultColumnWidth == 1 && value.id == "columnSetSizeSelect1") {
                                if(i == 12) {
                                    var selected = value.values[optKey].value;
                                    $("#advanced-form-columnSetSizeSelect1").val(selected);
                                }
                                ++i;
                            }
                        });
                    }

                    // @todo add other options if needed
                });



            });
        },
        formHelperGetOption:function (arr, parentElem) {
            // append options
            var option = $('<option/>');
            option.attr({ 'value': arr['value'] }).text(arr['title']);
            $(parentElem).append(option);
        },
        onChangeSelectFields: function () {
            var previous = [],
                prefix = '';
            $("#advancedFormContainer select").on('focus', function () {
                // store current value on focus and on change
                previous[this.id] = this.value;
            }).change(function() {
                var advancedCss = $("#ctrl_advancedCss");
                var arrAdvancedCss = advancedCss.val().split(" ");
                var del = arrAdvancedCss.indexOf(previous[this.id]);
                if(this.value != "-" && previous[this.id] != "-") {
                    arrAdvancedCss.splice(del, 1);
                    arrAdvancedCss.push(this.value);
                }
                else if(this.value == "-" && previous[this.id] != "") {
                    if(advancedClassesSet == 'materialize.json') {// fix for materializecss
                        // if(this.value.indexOf('.s') === -1 || this.value.indexOf('.m') === -1 || this.value.indexOf('.l') === -1)

                    }
                    arrAdvancedCss.splice(del, 1);
                } else
                    arrAdvancedCss.push(this.value);

                // write array to css class
                advancedCss.val(arrAdvancedCss.join(" "));
                // update the previous value
                previous[this.id] = this.value;
            });
        },
        setSelectFieldsFromCss: function () {
            var advancedCss = $("#ctrl_advancedCss");
            if(typeof advancedCss != "undefined") {
                var prefix = '';
                var lastClass = '';
                var arrAdvancedCss = advancedCss.val().split(" ");
                arrAdvancedCss.forEach(function (cssClass) {
                    if(advancedClassesSet == 'materialize.json') {// fix for materializecss
                        if(cssClass.indexOf('.s') === -1 || cssClass.indexOf('.m') === -1 || cssClass.indexOf('.l') === -1)
                            prefix = 'col ';
                    }
                    $('#advancedFormContainer select option[value="' + prefix + cssClass + '"]')
                        .prop('selected', true)
                        .attr('selected', 'selected');
                    lastClass = cssClass;
                });
            }
        },
        hideAdvancedCssInput: function() {
            this.rootElem.children("div").first().hide();
        }
    };

    $(document).ready(function () {
        AdvancedClasses.onReady()
    });

})(jQuery);