$(function() {
    var minwidth_sandwichfilter = {};
    
    $(document).ready(function(){
        // Функция активации Select2
        funcSelect2();
        
        // Функция активации Select2
        funcSandwichFilter();
        
        // Функция дает возможность сбросить введенные данные в input
        funcInputClear();
        
        /* Добавление, редактирование, удаление */
        funcDeleteFieldLine();
        funcEditFieldLine();
        funcAddFieldLine();
    });
    
    /* ---------- Функция добавления записи в справочнике ---------- */
    function funcAddFieldLine(){
        /* Открыть модальное окно добавления записи */
        $('body').on('click', '[data-add_field_line]', function(){
            let block = $(this),
                modal = $('#' + block.data('add_field_line'));

            $.ajax({
                type: 'GET',
                url: block.data('action'),
                data: {},
                dataType: "html",
                success:function(msg) {
                    modal.find('[data-modal_edit_field_one]').html(msg);

                    count_columnscreate = count_columnscreate + 1;
                    funcColumnsCreate(count_columnscreate);

                    funcSelect2();
                    modal.modal('show');
                }
            });
        });

        /* Добавить запись */
        $('body').on('submit', '[data-add_field_line_one_form]', function() {
            let form        = $(this),
                id          = form.data('add_field_line_one_form'),
                form_data   = collectModalEditFieldOne(form),
                btn = form.find('[type="submit"]');

            form.find('[data-alert]').addClass('hide').html('');

            $.ajax({
                type: 'POST',
                url: form.data('action'),
                data: form_data,
                dataType: "json",
                contentType: false,
                processData:false,
                beforeSend: function(){
                    btn.addClass('loadblock s50');
                },
                success:function(msg) {
                    if(msg.error){
                        form.find('[data-alert]').removeClass('hide').html(msg.error);
                    } else {
                        location.reload();
                    }

                    btn.removeClass('loadblock s50');
                },
                error:function(data) {
                    form.find('[data-alert]').removeClass('hide').html(($.parseJSON(data.responseText)).message);
                    btn.removeClass('loadblock s50');
                }
            });

            return false;
        });

        /* Добавить запись с обновление селекта */
        $('body').on('submit', '[data-add_field_line_one_form_upselect]', function() {
            let form        = $(this),
                name        = form.data('add_field_line_one_form_upselect'),
                uniq        = form.data('uniq'),
                form_data   = collectModalEditFieldOne(form),
                btn         = form.find('[type="submit"]'),
                upselect    = $('[data-update_select="' + name + '"][data-uniq="' + uniq + '"]').parents('[data-update_select_content]').find('select[name="' + name + '"]'),
                orfield     = form.find('input[name="' + form.data('origin_field') + '"]');

            form.find('[data-alert]').addClass('hide').html('');

            $.ajax({
                type: 'POST',
                url: form.data('action'),
                data: form_data,
                dataType: "json",
                contentType: false,
                processData:false,
                beforeSend: function(){
                    btn.addClass('loadblock s50');
                },
                success:function(msg) {
                    if(msg.error){
                        form.find('[data-alert]').removeClass('hide').html(msg.error);
                    } else {
                        upselect.append('<option value="' + msg.data + '">' + orfield.val() + '</option>');
                        upselect.find('option:last').prop('selected', true);
                        form.parents('.modal').find('.close-modal').click();
                        dselect(upselect[0], { search: true });

                        if($.inArray(uniq, ['risk_edit_category_id', 'risk_edit_soa_id']) != -1){
                            ajaxFormTabComponent({}, false, 1, $('[data-form_tab_component]'), 0, 'risk');
                        }
                    }

                    btn.removeClass('loadblock s50');
                },
                error:function(data) {
                    form.find('[data-alert]').removeClass('hide').html(($.parseJSON(data.responseText)).message);
                    btn.removeClass('loadblock s50');
                }
            });

            return false;
        });

        /* сбор данных добавленной записи формы */
        function collectModalEditFieldOne(form){
            let result = new FormData();

            form.find('input[name], textarea[name], select[name]').each(function(){
                let block = $(this),
                    type = this.tagName.toLowerCase(),
                    name = block.attr('name'),
                    text = '';

                if (type == 'input' && block.attr('type') == 'file'){
                    result.append(name, block.prop('files')[0]);
                } else if (type == 'input' && $.inArray(block.attr('type'), ['checkbox', 'radio']) !== -1 && block.is(':checked')) {
                    result.append(name, block.val());
                } else if ($.inArray(name, ['constr:columns', 'constr:depth']) !== -1) {

                    /* костыль на сохранение колонны start */
                    if(!result.has('columns')){
                        let columns = {};

                        $('input[name="constr:columns"]').each(function(index){
                            let block = $(this),
                                value = block.val().split('|'),
                                block_index = index;

                            if(typeof columns[block_index] === 'undefined'){ columns[block_index] = {}; }
                            columns[block_index] = { 'type_id':  value[0], 'column_id':  value[1]};

                            block.parents('[data-column_control]').find('input[name]').each(function(){
                                let block_input = $(this),
                                    block_input_name = block_input.attr('name');

                                if(block_input_name != 'constr:columns'){
                                    columns[block_index][block_input.attr('name').split(':')[1]] = block_input.val().split('|')[1];
                                }
                            });
                        });

                        result.append('columns', JSON.stringify(columns));
                    }
                    /* костыль на сохранение колонны end */

                } else {
                    if($.inArray(block.attr('type'), ['checkbox', 'radio']) === -1){
                        result.append(name, block.val());
                    }
                }
            });

            return result;
        }
    }
    
    /* ---------- Функция удаления записи в справочнике ---------- */
    function funcDeleteFieldLine(){
        $('body').on('click', '[data-delete_field_line]', function(){
            let block = $(this),
                modal = $('#' + block.data('delete_field_line')),
                head = block.data('head'),
                text = block.data('text');

            modal.modal('show');
            modal.find('[data-modal_delete_field_head]').html(head.toLowerCase());
            modal.find('[data-modal_delete_field_text]').html(text.toLowerCase());
            modal.find('[data-modal_delete_field_delete]').attr('data-modal_delete_field_delete', block.data('action'));
        });

        $('body').on('click', '[data-modal_delete_field_delete]', function(){
            let block = $(this);

            $.ajax({
                type: 'DELETE',
                url: block.attr('data-modal_delete_field_delete'),
                data: {
                    '_token': block.data('token')
                },
                dataType: "json",
                beforeSend: function(){
                    block.addClass('loadblock s50');
                },
                success:function(msg) {
                    if(!msg.error){
                        location.reload();
                    }
                }
            });
        });
    }
    
    /* ---------- Функция редактирования записи в справочнике ---------- */
    function funcEditFieldLine(){
        /* Открыть модальное окно редакируемой записи */
        $('body').on('click', '[data-edit_field_line]', function(){
            let block = $(this),
                modal = $('#' + block.data('edit_field_line')),
                status_upselect = false;

            if(typeof block.data('update_select') !== "undefined"){
                status_upselect = true;
            }

            $.ajax({
                type: 'GET',
                url: block.data('action'),
                data: {},
                dataType: "html",
                success:function(msg) {
                    modal.find('[data-modal_edit_field_one]').html(msg);

                    count_columnscreate = count_columnscreate + 1;
                    funcColumnsCreate(count_columnscreate);

                    funcSelect2();

                    if(status_upselect){
                        if(block.data('type') == 'add'){
                            modal.find('[data-add_field_line_one_form]')
                                .removeAttr('data-add_field_line_one_form')
                                .attr('data-add_field_line_one_form_upselect', block.data('update_select'))
                                .attr('data-uniq', block.data('uniq'))
                                .attr('data-origin_field', block.data('origin_field'));

                            modal.attr('data-bs-backdrop', 'static');
                            modal.modal('show');

                            $('.modal-backdrop').last().addClass('active');
                        }
                    } else {
                        modal.modal('show');
                    }
                }
            });
        });

        /* Изменение редакируемую запись */
        $('body').on('submit', '[data-modal_edit_field_one_form]', function() {
            let form        = $(this),
                id          = form.data('modal_edit_field_one_form'),
                form_data   = collectModalEditFieldOne(form),
                btn = form.find('[type="submit"]');

            form.find('[data-alert]').addClass('hide').html('');

            $.ajax({
                type: 'POST',
                url: form.data('action'),
                data: form_data,
                dataType: "json",
                contentType: false,
                processData:false,
                beforeSend: function(){
                    btn.addClass('loadblock s50');
                },
                success:function(msg) {
                    if(msg.error){
                        form.find('[data-alert]').removeClass('hide').html(msg.error);
                    } else {
                        form.find('input[name], textarea[name], select[name]').each(function() {
                            let type = this.tagName.toLowerCase(),
                                name = $(this).attr('name'),
                                text = '';

                            if(type == 'select'){
                                let select_text = form.find(type + '[name="' + $(this).attr('name') + '"]').find('option:selected');
                                step_data = 0;

                                select_text.each(function(){
                                    step_data++;
                                    text = text + ((step_data != 1)? '<br>' : '') + $(this).text();
                                });
                            } else {
                                text = $(this).val();
                            }

                            updateModalEditFieldOne(form, id, name, text, msg);
                            funcDottedLine();
                            resizeAuto100();
                        });

                        $('.close-modal').click();
                    }

                    btn.removeClass('loadblock s50');
                },
                error:function(data) {
                    form.find('[data-alert]').removeClass('hide').html(($.parseJSON(data.responseText)).message);
                    btn.removeClass('loadblock s50');
                }
            });

            return false;
        });

        /* сбор данных редакируемой записи формы */
        function collectModalEditFieldOne(form){
            let result = new FormData();

            /* сбор значения формы подписки */
            if(form.attr('data-form_name') !== undefined && form.data('form_name') == 'subscribe') { result.append('subscribe', 0); }

            form.find('input[name], textarea[name], select[name]').each(function(){
                let block = $(this),
                    type = this.tagName.toLowerCase(),
                    name = block.attr('name'),
                    text = '';

                /* сбор значения формы подписки */
                if(form.attr('data-form_name') !== undefined && form.data('form_name') == 'subscribe' && name == 'subscribe' && block.is(':checked')) {
                    subscribe_value = result.get('subscribe');
                    result.set('subscribe', (parseFloat(subscribe_value) + parseFloat(block.data('weight'))));

                    return;
                }

                if (type == 'input' && block.attr('type') == 'file'){
                    result.append(name, block.prop('files')[0]);
                } else if (type == 'input' && $.inArray(block.attr('type'), ['checkbox', 'radio']) !== -1 && block.is(':checked')) {
                    result.append(name, block.val());
                } else if ($.inArray(name, ['constr:columns', 'constr:depth']) !== -1) {

                    /* костыль на сохранение колонны start */
                    if(!result.has('columns')){
                        let columns = {};

                        $('input[name="constr:columns"]').each(function(index){
                            let block = $(this),
                                value = block.val().split('|'),
                                block_index = index;

                            if(typeof columns[block_index] === 'undefined'){ columns[block_index] = {}; }
                            columns[block_index] = { 'type_id':  value[0], 'column_id':  value[1]};

                            block.parents('[data-column_control]').find('input[name]').each(function(){
                                let block_input = $(this),
                                    block_input_name = block_input.attr('name');

                                if(block_input_name != 'constr:columns'){
                                    columns[block_index][block_input.attr('name').split(':')[1]] = block_input.val().split('|')[1];
                                }
                            });
                        });

                        result.append('columns', JSON.stringify(columns));
                    }
                    /* костыль на сохранение колонны end */

                } else {
                    if($.inArray(block.attr('type'), ['checkbox', 'radio']) === -1){
                        result.append(name, block.val());
                    }
                }
            });

            return result;
        }

        /* обновление данных редакируемой записи в таблице */
        function updateModalEditFieldOne(form, id, name, text, msg){
            let block = $('[data-tr_event="' + id + '"]'),
                field = block.find('[data-td_event="' + name + '"]');

            if($.inArray(name, ['deadline', 'session_date', 'period_from', 'period_to']) !== -1){
                text = funcDateConverter('d.m.Y', text);
            }
            field.html(text);

            /* изменение значения таблицы подписки */
            if(form.attr('data-form_name') !== undefined && form.data('form_name') == 'subscribe'){
                $.each(msg.data, function(k, v){
                    block.find('[data-td_event="' + k + '"]').html(v);
                });
            }
        }
    }
    
    /* ---------- Функция отоюражения selecta фильтров, если элементы не вмещаются в объект ---------- */
    function funcSandwichFilter(){
        if($('[data-filterline__sandwich]').length > 0){
            sandwichFilterStatus();
            $(window).resize(function(){ sandwichFilterStatus(); });
            $(window).scroll(function(){ sandwichFilterStatus(); });

            /* Клик по первому уровню навигационного меню */
            $('body').on('click', '[data-filterline_sandwich_parent]', function(){
                let parent    = $(this),
                    status    = parent.hasClass('active') ?? false,
                    id        = parent.data('filterline_sandwich_parent'),
                    child     = $('[data-filterline_sandwich_child="' + id + '"]');

                parent.removeClass('active');
                child.addClass('hide');

                if(!status){
                    parent.addClass('active');
                    child.removeClass('hide');
                }
            });

            function sandwichFilterStatus(){
                $('[data-filterline__sandwich]').each(function(i){
                    let block = $(this);

                    if(block.parent().width() < block[0].scrollWidth && typeof minwidth_sandwichfilter[i] === 'undefined'){
                        minwidth_sandwichfilter[i] = block[0].scrollWidth;
                        block.addClass('mmot-filterline__sandwich__content');
                    } else {
                        if(block.parent().width() > minwidth_sandwichfilter[i]){
                            block.removeClass('mmot-filterline__sandwich__content');
                            delete minwidth_sandwichfilter[i];
                        }
                    }
                });
            }
        }
    }
    
    /* ---------- Функция дает возможность сбросить введенные данные в input ---------- */
    function funcInputClear(){
        $('[data-input_clear]').each(function(){ changeStatusInputClear($(this)); });

        $('body').on('blur', '[data-input_clear]', function(){ changeStatusInputClear($(this)); });

        $('body').on('click', '[data-input_clear_btn]', function(){
            $(this).parents('[data-input_clear_content]').find('input').val('');
            changeStatusInputClear($(this));
        });

        function changeStatusInputClear(block){
            let conteiner = block.parents('[data-input_clear_content]');

            conteiner.removeClass('mmot-inputwithico-right');
            conteiner.find('.mmot-inputwithico-right__ico').remove();

            if(block.val() != ''){
                conteiner.addClass('mmot-inputwithico-right');
                block.after('<svg class="mmot-inputwithico-right__ico" data-input_clear_btn><use xlink:href="#site-clear_input"></use></svg>');
                conteiner.find('input').attr('data-date', funcDateConverter('d.m.Y', block.val()));
            } else {
                conteiner.find('input').removeAttr("data-date");
            }
        }
    }
    
    /* Конвертер даты в другой формат стандартного html пикера */
    function funcDateConverter(format, date){
        date = date.split('-');
        return date[2] + '.' + date[1] + '.' + date[0];
    }
});

/* ---------- Функция активации Select2 ---------- */
function funcSelect2(){
    if ($('select').length > 0) {
        $('select').each(function(){
            let block = $(this),
                next = block.next('.dselect-wrapper');

            if(block.find('option').length > 0){
                if (next.length == 0) {
                    dselect(block[0], {
                        search: true
                    });
                }
            }
        });
    }
}