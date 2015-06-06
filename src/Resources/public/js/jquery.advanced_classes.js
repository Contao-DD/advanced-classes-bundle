(function ($) {

    var AdvancedClasses = {
        onReady: function () {
            this.json = '';
            this.rootElem = $('#pal_advanced_classes_legend');
            if($('#ctrl_advancedCss').length) {
                $.getJSON("system/modules/advanced_classes/assets/sets/bootstrap.json")
                    .done(function (json) {
                        AdvancedClasses.json = json;
                        AdvancedClasses.buildForm();
                        AdvancedClasses.onChangeSelectFields();
                        AdvancedClasses.setSelectFieldsFromCss();
                        AdvancedClasses.hideAdvancedCssInput();
                    }).fail(function (jqxhr, textStatus, error) {
                        var err = textStatus + ", " + error;
                        console.log("Request Failed: " + err);
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
                        var select = '<div class="value ' + value.class + ' ' + value.type + '" for="advanced-form-' + value.id + '"><select id="advanced-form-' + value.id + '" name="advanced-form-' + value.id + '" class="tl_select tl_chosen"><option>-</option></option></select></div>';
                        $("#" + section.secId).append(select);
                        Object.keys(value.values).forEach(function (optKey) {
                            AdvancedClasses.formHelperGetOption(value.values[optKey], "#advanced-form-" + value.id);
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
            var previous = [];
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
                var arrAdvancedCss = advancedCss.val().split(" ");
                arrAdvancedCss.forEach(function (cssClass) {
                    $('#advancedFormContainer select option[value="' + cssClass + '"]').prop('selected', true).attr('selected', 'selected');
                });
            }
        },
        hideAdvancedCssInput: function() {
            this.rootElem.children("div").first().hide();
        }
    }

    $(document).ready(function () {
        AdvancedClasses.onReady()
    });

})(jQuery);