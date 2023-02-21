//The options are on the bottom

(function ($) {
    $.fn.easySelect = function (options) {
        return this.each(function () {
            var settings = $.extend({
                search: false,
                buttons: false,
                placeholder: 'Select item',
                selectColor: '#414c52',
                placeholderColor: '#838383',
                itemTitle: 'Selected items',
                showEachItem: false,
                width: '100%',
                dropdownMaxHeight: 'auto'
            }, options);

            var $this = $(this),

            numberOfOptions = $(this).children('option').length;

            $this.addClass('s-hidden');

            $this.wrap('<div class="easySelect"></div>');
            var $main = $this.closest('.easySelect').css('width', settings.width);

            $this.after('<div class="styledSelect"></div>');

            var $styledSelect = $this.next('div.styledSelect');

            $styledSelect.text(settings.placeholder).css('color', settings.placeholderColor);

            var MaxAllowed = $this.data("max");
            
           var clear = $('<span/>',{
                'class': 'clearSelectfromDiv',
                 html: '&times;',
                'style': 'display: none',
            }).prependTo($main);
            
            var $list = $('<ul />', {
                'class': 'options'
            }).insertAfter($styledSelect);

            var $divSearch = $('<div/> ', {
                'class': 'divSearcheasySelect',
            }).appendTo($list)
            if(settings.search == false){
                $divSearch.hide();
            }
            
            
            var $divoptions = $('<div/> ', {
                'class': 'divOptionsesySelect',
            }).appendTo($divSearch);
            if(settings.buttons == false ){
                $divoptions.hide();
            }

            var $clearSpan = $('<p />', {
                'class': 'optionRow ',
                text: 'Clear all',
                'id': 'clearAlleasySelect',
            }).appendTo($divoptions);

            var $clear = $('<span />', {
                'class': 'alleasySelect',
                html: '&times;'
            }).appendTo($clearSpan);

            var $selectAllspan = $('<p />', {
                'class': 'optionRow',
                'id': 'selectAlleasySelect',
                text: 'Select all'
            }).appendTo($divoptions);

            var $selectAll = $('<span />', {
                'class': 'alleasySelect',
                html: '&check;'
            }).appendTo($selectAllspan);

            var $message = $('<p />', {
                'class': 'messageMaxallowedSelections',
                style: 'display:none',
                text: 'You can select max ' + MaxAllowed + ' items '
            }).appendTo($divoptions);

            var $searchInput = $('<input/> ', {
                'type': 'text',
                'class': 'searchInputeasySelect',
                'placeholder': 'Search',
            }).appendTo($divSearch)

            var $maindiv = $('<div/> ', {
                'class': 'scrolableDiv',
            }).appendTo($list);
            $maindiv.css('max-height', settings.dropdownMaxHeight);

            var $hiddenli = $('<li/> ', {
                text: 'You can select only ' + MaxAllowed + ' items',
                'class': 'hiddenLieasySelect',
                style: 'display: none'
            }).appendTo($list);


            for (var i = 0; i < numberOfOptions; i++) {
                var $li = $('<li/> ').appendTo($maindiv);

                var $label = $('<label/> ', {
                    'class': 'container',
                    text: $this.children('option').eq(i).text(),
                }).appendTo($li)

                var $checkbox = $('<input> ', {
                    'class': 'mulpitply_checkbox_style',
                    'type': 'checkbox',
                    value: $this.children('option').eq(i).val(),
                }).appendTo($label)

                $('<span /> ', {
                    'class': 'checkmark',
                }).appendTo($label)
            }

            var $listItems = $list.find('li');
            var checkItem = $list.find('.mulpitply_checkbox_style');

            $styledSelect.click(function (e) {
                e.stopPropagation();
                $('div.styledSelect.active').each(function () {
                    $(this).removeClass('active').next('ul.options').hide();
                });
                $(this).toggleClass('active').next('ul.options').toggle();
            });

            function eachItem() {
                arrText = [];
                $.each($list.find('.mulpitply_checkbox_style:checked'), function () {
                    arrText.push($(this).parent().text());
                });
            }

            function eachItemoutput() {
                
                if (settings.showEachItem == true) {
                    $styledSelect.text(arrText.join(", ")).removeClass('active').css('color', settings.selectColor); 
                    
                } else {
                    var $checked_items = checkItem.filter(":checked").length;
                    $styledSelect.text($checked_items + ' ' + settings.itemTitle).removeClass('active').css('color', settings.selectColor);
                   
                }
            }
                

            $listItems.click(function (e) {
                e.stopPropagation();
                $styledSelect.text($(this).text()).removeClass('active');
                $this.val($(this).attr('val'));
                clear.show();

                val = [];
                $('.mulpitply_checkbox_style:checked').each(function () {
                    val.push($(this).val());
                })
                $this.closest('select').val(val);

                $($this.closest('select').children('option:selected')).each(function () {
                    $(this).attr('selected', 'selected');
                });

                arrVal = [];
                var getVal = $.each($('.mulpitply_checkbox_style:checked'), function () {
                    arrVal.push($(this).val());
                });
                /*--===============================*/
                eachItem();
                eachItemoutput();

                var $checked_items = checkItem.filter(":checked").length;
                if ($checked_items == 0) {
                    $styledSelect.text(settings.placeholder).removeClass('active').css('color', settings.placeholderColor);
                    clear.hide();
                }

                var MaxAllowed = $this.data("max");
                if ($checked_items >= MaxAllowed && MaxAllowed !== "") {
                    checkItem.not(":checked").attr("disabled", "disabled");
                    $maindiv.hide();
                     $divSearch.hide();
                    $hiddenli.show();
                } else {
                    // Enable the inputs again when he unchecks one
                    checkItem.removeAttr("disabled");
                }
            });

            var $optionRow = $list.find('.optionRow');

            $optionRow.click(function (e) {
                e.stopPropagation();
            });
            var $clearAll = $list.find('#clearAlleasySelect');
            var $selectAll = $list.find('#selectAlleasySelect');

/*--================================*/
            function unselectAll() {
                checkItem.prop('checked', false);
                $styledSelect.text(settings.placeholder).removeClass('active').css('color', settings.placeholderColor);
                $this.closest('select').val('');
                $maindiv.show();
                $hiddenli.hide();
            }
            $clearAll.click(function () {
                clear.hide();
                unselectAll()
            })
            clear.click(function () {
                $(this).hide();
                
                unselectAll()
            })
/*--================================*/
            allValue = [];
            $selectAll.click(function () {
                if (MaxAllowed == "" || typeof MaxAllowed == typeof undefined) {
                    checkItem.prop('checked', true);
                    $('.mulpitply_checkbox_style:checked').each(function () {
                        allValue.push($(this).val());
                    })
                    $this.closest('select').val(allValue);
                    clear.show();
                    eachItem();
                    eachItemoutput();
                } else {
                    $message.css('display', 'inline-block');
                    setTimeout(function () {
                        $message.hide()
                    }, 2000);
                }
            })

            $(document).click(function () {
                $styledSelect.removeClass('active');
                $list.hide();
            });

            var $block = $('<li/> ', {
                'class': 'no_results',
                text: 'No results found..',
            }).appendTo($list)
            $block.hide();
            var $input = $divSearch.find('input[type="text"]');
            $input.click(function (e) {
                e.stopPropagation();
            });
            $input.keyup(function () {
                var val = $(this).val();
                var isMatch = false;
                $listItems.find('.container').each(function (i) {
                    var content = $(this).html();
                    if (content.toLowerCase().indexOf(val) == -1) {
                        $(this).hide();
                    } else {
                        isMatch = true;
                        $(this).show();
                    }
                });
                $block.toggle(!isMatch);
            });
        });
    }
}(jQuery));

    
