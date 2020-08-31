jQuery(document).ready(function() {
    $('.js_field_path').each(function(){
        var _this = $(this);
        $(this).FieldPath({
            limit: _this.data('limit'),
            placeholder: _this.data('placeholder'),
            name : _this.data('name'),
            value : _this.data('value'),
            iClass : _this.data('class')
        });
    });
    App.init();
    
    //FormValidation.init();
    $('.toggle_button').toggleButtons({
        label: {
          enabled: 'BẬT',
          disabled: 'TẮT'
        }
    });
    $('.select2').select2();
    $('.multiSelect').multiSelect();
    $(".datepicker").datepicker({isRTL: App.isRTL()});
    $('.clockface').clockface({
        format: 'hh:mm A'
    });
    $(".colorpicker").colorpicker();
    $(".mask_number").inputmask({ "mask": "9", "repeat": 10, "greedy": false });
    $(".mask_currency").inputmask('VNĐ 999.999.999', { numericInput: true });
    $(".datetimepicker").datetimepicker({
        format: "yyyy-mm-dd hh:ii:ss",
        autoclose: true,
        pickerPosition: "top-left",
        todayBtn: true
    });
    
    $('.form-date-range').each(function(){
        var _this = $(this);
        var $_startDate, $_endDate;
        $_startDate = _this.find('input[name=txt_start]').val();
        $_endDate = _this.find('input[name=txt_end]').val();
        if($_startDate) var d_start = new Date($_startDate); else var d_start = Date.today().add({days: -29});
        if($_endDate) var d_end = new Date($_endDate); else var d_end = Date.today();
        $(this).daterangepicker({
            ranges: {
                'Hôm nay': ['today', 'today'],
                'Hôm qua': ['yesterday', 'yesterday'],
                '7 ngày trước': [Date.today().add({
                        days: -6
                    }), 'today'],
                '29 ngày trước': [Date.today().add({
                        days: -29
                    }), 'today'],
                'Tháng này': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
                'Tháng trước': [Date.today().moveToFirstDayOfMonth().add({
                        months: -1
                    }), Date.today().moveToFirstDayOfMonth().add({
                        days: -1
                    })]
            },
            opens: (_this.attr('data-left')=="true" ? 'left' : 'right'),
            format: 'dd/MM/yyyy',
            separator: ' to ',
            startDate: d_start,
            endDate: d_end,
            locale: {
                applyLabel: 'OK',
                fromLabel: 'Từ',
                toLabel: 'Đến',
                customRangeLabel: 'Tùy chỉnh',
                daysOfWeek: ['CN', 'HA', 'Ba', 'TU', 'NA', 'SA', 'BA'],
                monthNames: ['T. Một', 'T. Hai', 'T. Ba', 'T. Bốn', 'T. Năm', 'T. Sáu', 'T. Bảy', 'T. Tám', 'T. Chín', 'T. Mười', 'Mười Một', 'Mười Hai'],
                firstDay: 1
            },
            showWeekNumbers: true,
            buttonClasses: ['btn-danger']
        },
    
        function (start, end) {
            _this.find('span').html(start.toString('dd/MM/yyyy') + ' - ' + end.toString('dd/MM/yyyy'));
            _this.find('.txt_start').val(start.toString('yyyy-MM-dd'));
            _this.find('.txt_end').val(end.toString('yyyy-MM-dd'));
        });
    
        _this.find('span').html(d_start.toString('dd/MM/yyyy') + ' - ' + d_end.toString('dd/MM/yyyy'));
    });
    
    $.extend($.gritter.options, {
        position: 'bottom-left',
        sticky: true
    });
    
    $('.maxlength').maxlength({
        limitReachedClass: "label label-danger",
        alwaysShow: true
    });
    $('input.tags').tagsInput({
        width: 'auto',
        defaultText: 'thêm từ khóa'
    });
    $('.btn_open_hide').click(function(){
        $(this).parents('.root').addClass('hide');
        $($(this).attr('href')).removeClass('hide');
        return false;
    });
    $('.maxchar').each(function(){
        var maxchar = $(this).attr('maxchar');
        var label = $('<span class="badge badge-info hide" style="position: absolute; top: -17px; right: 0;"></span>');
        $(this).parent().css('position', 'relative');
        label.appendTo($(this).parent());
        var obj = $(this);
        var length = 0;
        obj.focus(function(){
            label.removeClass('hide');
        }).blur(function(){
            var val = $(this).val();
            if(val) length = val.split(' ').length;
            else length = 0;
            if(length>maxchar) {
                $(this).parents('.control-group').addClass('error');
            }
            label.addClass('hide');
        }).keyup(function(){
            var val = $(this).val();
            if(val) length = val.split(' ').length; else length = 0;
            label.text(length+' / '+maxchar);
            if(length>=maxchar) {
                label.removeClass('badge-info');
                if(length==maxchar) label.addClass('badge-success');
            }
            else if(length<maxchar) label.addClass('badge-info');
            if(length!=maxchar) label.removeClass('badge-success');
            if(length<=maxchar && obj.parents('.control-group').hasClass('error')) obj.parents('.control-group').removeClass('error');
        });
        obj.parents('form').submit(function(){
            if(obj.parents('.control-group').hasClass('error')) {
                alert(obj.parents('.control-group').find('.control-label').text()+' không được nhiều hơn '+maxchar+' chữ');
                obj.focus();
                return false;
            }
        });
        obj.keyup();
    });
});