var result = 1;
$(function (){

    var yellowFlag          = [];
    var redFlag             = [];

    var states               = ['Alaska', 'Arkansas', 'California', 'Connecticut', 'Delaware', 'Georga', 'Idaho', 'Indiana', 'Iowa', 'Kentucky',
                            'Louisiana', 'Maryland', 'Massachusetts', 'Mississippi', 'Montana', 'Nevada', 'New Hampshire', 'New Jersey', 'North Carolina', 'North Dakota',
                            'Ohio', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Dakota', 'Tennessee', 'Utah', 'Vermont', 'Virginia', 'West Virginia'];

    var StatesArray = $.map(statesArray, function (team) { return { value: team, data: { category: 'NBA' } }; });
    var $state      = $('#state');
    $('#state').autocomplete({
        lookup: StatesArray,
        onSelect: function (suggestion) {
            $('#state').parent().removeClass('invalid');
            $('.fielderrors').hide();
        }
    });
    var form        = $("#signup-form");
    var stepsTitle  = [];
    var phrase      = 'Aasdpl234fdjakspqewrqwcnxsqqwer';
    $('.idealsteps-wrap section').each(function(){
        stepsTitle.push($(this).data('title'));
    })

    //--- Form step script
    $('form.idealforms').idealforms({

        //silentLoad: false,
        fadeSpeed: 5,
        steps:{
//                    MY_stepsItems: ['One', 'Two', 'Three'],
            MY_stepsItems: stepsTitle,
            buildNavItems: function(i) {
                return this.opts.steps.MY_stepsItems[i];
            }
        },
        displayStepCounter: false,
        rules: {
            'first_name': 'required',
            'last_name': 'required',
            'email': 'required email',
            'password': 'required pass',
            'confirm': 'required equalto:password'//,
            //'date': 'required date',
            //'picture': 'required extension:jpg:png',
            //'website': 'url',
            //'hobbies[]': 'minoption:2 maxoption:3',
            //'phone': 'required phone',
            //'zip': 'required zip',
            //'options': 'select:default',
        },

        errors: {
            //'username': {
            'email': {
                ajaxError: 'Username not available'
            }
        },

        onSubmit: function(invalid, e) {
            e.preventDefault();
            save_signup();
            /*$('#invalid')
                .show()
                .toggleClass('valid', ! invalid)
                .text(invalid ? (invalid +' invalid fields') : 'All good!');*/
        }

    });

    $('form.idealforms').find('input, select, textarea').on('change keyup', function() {
        $('#invalid').hide();
    });

    $('form.idealforms').idealforms('addRules', {
        'comments': 'required minmax:50:200'
    });

    $('.prev').click(function(){
        $('.prev').show();
        $('form.idealforms').idealforms('prevStep');
    });
    $('.next').click(function(){
        $('.next').show();
        $('form.idealforms').idealforms('nextStep');
    });

    //-- next step button events
    $('.secondary-step-next').click(function(){
        var $this       = $(this);
        var invalid_ctr = 0;
        var $step       = $this.closest('.secondary-step');
        $step.find('input,textarea,select').each(function(index){
            var $item = $(this);
            if($(this).hasClass('required')){
                //console.log('required');
                if($(this).val() == ''){
                    invalid_ctr++;
                    $(this).parent().addClass('invalid');
                    $step.find('.fielderrors').text('Please fill in the required field(s)!').show();
                }
            }else{
                if( $(this).parent().hasClass('invalid')){
                    $(this).parent().removeClass('invalid');
                    $('.fielderrors').text('').hide();
                }
            }
        });


        if(invalid_ctr > 0){
            //console.log(invalid_ctr);
            return false;
        }

        tempSave($step.attr('id'), $this);

        //if(result == 1){
        //    $this.closest('.secondary-step').fadeOut('fast',function(){
        //        $this.closest('.secondary-step').removeClass('active');
        //        $this.closest('.secondary-step').hide();
        //
        //    }).next().delay(500).fadeIn('fast', function(){
        //        if($(this).attr('id') == 'retirement-plan'){
        //            $('.next').show();
        //        }
        //        $(this).addClass('active');
        //    });
        //}else{
        //    return false;
        //}

    });

    // -- Previous Button events
    $('.secondary-step-prev').click(function(){
        var $this   = $(this);
        $this.closest('.secondary-step').fadeOut('fast',function(){
            $this.closest('.secondary-step').removeClass('active');
            $this.closest('.secondary-step').hide();
        }).prev().delay(500).fadeIn('fast', function(){
            if($(this).attr('id') == 'retirement-plan'){
                $('.next').hide();
            }
            $(this).addClass('active');
        });
    });


    //--- End of form step script

    $('.prefill').on('blur', function(){
        var field   = $(this);
        var id      = field.attr('id');
        var val     = field.val();
        $('#prefill-' + id).text(val);
    });

    //input mask for number only
    //--- Form step script
    //$(".numericOnly").numberOnly({
    //    valid: "0123456789+-.$,"
    //});
    $(".numericOnly").numberOnly();

    $('#age').on('blur', function(){
       var $this = $(this)
        if($this.val() != ''){

        }
    });

    //--- Radio button on change events
    $('#signup-form input[name=married]').change(function(){
        var value = $( 'input[name=married]:checked' ).val();
        if(value == 'Yes'){
            $('#spouse-container').show();
        }else{
            $('#spouse-container').css({'display': 'none'});
        }
    });

    $('#number_children').change(function(){
        var val     = $(this).val();
        var html    = '';
        if(val != 'specify'){
            for(var i = 1; i<= val; i++){
                html += '<div class="input-group">'
                    + '<div class="col-sm-8"><input type="text" name="child[][name]" value="" id="childname-'+ i +'" placeholder="Child\'s Name.." class="form-control"></div>'
                    + '<div class="col-sm-4"><input type="text" name="child[][age]" value="" id="childage-'+ i +'" placeholder="Child\'s Age.." class="form-control"></div>'
                    + '</div>';
            }
            $('#childrens').html(html);
            $('#specified_number_children_container').css({'display': 'none'});
        }else{
            $('#childrens').html('');
            $('#specified_number_children_container').show();
            $('#specified_number_children').on('blur',function(){
                var $this_    = $(this);
                var $val      = $this_.val();
                for(var i = 1; i<= $val; i++){
                    html += '<div class="input-group">'
                        + '<div class="col-sm-8"><input type="text" name="child[][name]" value="" id="childname-'+ i +'" placeholder="Child\'s Name.." class="form-control"></div>'
                        + '<div class="col-sm-4"><input type="text" name="child[][age]" value="" id="childage-'+ i +'" placeholder="Child\'s Age.." class="form-control"></div>'
                        + '</div>';
                }
                $('#childrens').html(html);
            })
        }


    });

    $('#signup-form input[name=do_you_have_large_expenses_coming_up]').change(function(){
        var val  = $('input[name=do_you_have_large_expenses_coming_up]:checked').val();

        if(val == 'Yes'){
            $('#expenses').show()
        }else{
            $('#expenses').css({'display': 'none'});
        }
    });

    $('#expense_amount').prop('disabled', true);
    $('#timeframe').prop('disabled', true);

    $('#expense').change(function(){
        var val     = $(this).val()
        if(val){
            $('#expense_amount').prop('disabled', false);
            $('#timeframe').prop('disabled', false);
        }else{
            $('#expense_amount').prop('disabled', true);
            $('#timeframe').prop('disabled', true);
        }
    });

    $('#no_will').css({'display': 'none'});
    $('#has_will').css({'display': 'none'});

    $('#signup-form input[name=do_you_have_a_will]').change(function(){
        var val  = $('input[name=do_you_have_a_will]:checked').val();
        if(val == 'Yes'){
            $('#no_will').css({'display': 'none'});
            $('#has_will').show();
        }else{
            $('#no_will').show();
            $('#has_will').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_have_life_insurance]').change(function(){
        var val  = $('input[name=do_you_have_life_insurance]:checked').val();
        if(val == 'Yes'){
            $('#has_death_insurance').show();
        }else{
            $('#has_death_insurance').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=benefit_type]').change(function(){
        var val = $('input[name=benefit_type]:checked').val();
        if(val == 'Permanent'){
            $('#benefit_type_permanent_yes').show();
        }else{
            $('#benefit_type_permanent_yes').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=ltc_rider_of_accelerated_benefit]').change(function(){
        var val  = $('input[name=ltc_rider_of_accelerated_benefit]:checked');
        console.log(val.attr('id'));
        if(val.attr('id') == 'yes_i_have_a_rider'){
            $('#has_rider').show();
            $('#annual_death_benefit').css({'display': 'none'});
        }else if(val.attr('id') == 'yes_i_have_accelerated_benefit'){
            $('#has_rider').css({'display': 'none'});
            $('#annual_death_benefit').show();
        }else{
            $('#has_rider').css({'display': 'none'});
            $('#annual_death_benefit').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy]').change(function(){
        var val  = $('input[name=do_you_have_any_health_conditions_that_would_greatly_affect_your_expectancy]:checked').val();

        if(val == 'Yes'){
            $('#age_to_assume').show();
        }else{
            $('#age_to_assume').css({'display': 'none'});
        }
    })

    $('#signup-form input[name=does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy]').change(function(){
        var val  = $('input[name=does_your_spouse_have_any_health_conditions_that_would_greatly_affect_your_live_expectancy]:checked').val();

        if(val == 'Yes'){
            $('#age_to_assume2').show();
        }else{
            $('#age_to_assume2').css({'display': 'none'});
        }
    });


    $('#signup-form input[name=do_you_plan_on_working_part_time_in_retirement]').change(function(){
       var val  = $('input[name=do_you_plan_on_working_part_time_in_retirement]:checked').val();
        if(val == 'Yes'){
            $('.part_time_plan').show();
        }else{
            $('.part_time_plan').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_know_your_social_security_benefit_at_retirement]').change(function(){
        var val  = $('input[name=do_you_know_your_social_security_benefit_at_retirement]:checked').val();
        if(val == 'Yes'){
            $('.know_retirement_benefit').show();
        }else{
            $('.know_retirement_benefit').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_know_your_social_security_benefit_at_retirement]').change(function(){
        var val  = $('input[name=do_you_know_your_social_security_benefit_at_retirement]:checked').val();
        if(val == 'Yes'){
            $('.know_retirement_benefit').show();
        }else{
            $('.know_retirement_benefit').css({'display': 'none'});
        }
    });

    $('#signup-form input[name=do_you_or_your_spouse_have_a_pension]').change(function(){
        var val  = $('input[name=do_you_or_your_spouse_have_a_pension]:checked').val();
        if(val == 'Yes'){
            $('#pension_page').show();
        }else{
            $('#pension_page').css({'display': 'none'});
        }
    });
    /**
     * for pension
     */
    var pension_count = 0;
    $('#add_pension').click(function()
        {
            pension_count++;
            $('#pension_page #pension_content').append(
                '<div id="pension_'+pension_count+'" class="row">'+
                    '<div class="col-md-4">'+
                        '<div><label for="">Pension Type</label></div>'+
                        '<div class="group">'+
                            '<label for="'+pension_count+'_pension_type_public"><input type="radio" name="pension['+pension_count+'][type]" id="'+pension_count+'_pension_type_public" value="Public"> Public</label>'+
                            '<label for="'+pension_count+'_pension_type_private"><input type="radio" name="pension['+pension_count+'][type]" id="'+pension_count+'_pension_type_private" value="Private"> Private</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-4">'+
                        '<div><label for="">Does it have a cost of living adjustment?</label></div>'+
                        '<div class="group">'+
                        '<label for="'+pension_count+'_does_it_have_a_cost_of_living_adjustment_yes"><input type="radio" name="pension['+pension_count+'][does_it_have_a_cost_of_living_adjustment]" id="'+pension_count+'_does_it_have_a_cost_of_living_adjustment_yes" value="Yes"> Yes</label>'+
                        '<label for="'+pension_count+'_does_it_have_a_cost_of_living_adjustment_no"><input type="radio" name="pension['+pension_count+'][does_it_have_a_cost_of_living_adjustment]" id="'+pension_count+'_does_it_have_a_cost_of_living_adjustment_no" value="No"> No</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-md-4">'+
                        '$ <input type="text" id="'+pension_count+'_projected_monthly_pension_benefit" name="pension['+pension_count+'][projected_monthly_pension_benefit]" class="numericOnly form-control" placeholder="Projected monthly pension benefit.">'+
                    '</div>'+



                    '<label for="">Survivor Benefit?</label>'+
                    '<div class="field">'+
                        '<label for="'+pension_count+'_survivor_benefit_yes"><input type="radio" class="pension_radio" name="pension['+pension_count+'][survivor_benefit]" id="'+pension_count+'_survivor_benefit_yes" value="Yes"> Yes</label>'+
                        '<label for="'+pension_count+'_survivor_benefit_no"><input type="radio" class="pension_radio" name="pension['+pension_count+'][survivor_benefit]" id="'+pension_count+'_survivor_benefit_no" value="No"> No</label>'+
                    '</div>'+
                    '<div class="survivor_benefit">'+
                        '<label for="">What % gets passed on?</label>'+
                        '<div class="field">'+
                            '<input type="text" id="'+pension_count+'_what_percent_gets_passed_on" name="pension['+pension_count+'][what_percent_gets_passed_on]" class="numericOnly">% '+
                        '</div>'+
                    '</div>'+
                    '<a href="javascript:void(0)" class="remove_pension">Remove Pension</a>'+
                '</div>'
            );
            remove();
            pension();
        }
    );


    //--- Radio button change events scripts end
    $('#estimated_monthly_living_expenses_dont_know').click(function(){
        console.log(1);
        if($(this).checked()==true)
        {
            $('#estimated_monthly_living_expenses').prop('disabled',true);
        }
        else
        {
            $('#estimated_monthly_living_expenses').prop('disabled',false);
        }
    });


    // -- functions
    function pension()
    {
        $(".pension_radio").change(function()
            {
                var radio_name= $(this).attr('name');
                var val  = $('input[name="'+radio_name+'"]:checked').val();
                if(val == 'Yes'){
                    $(this).parents('div.group').next().show();
                }else{
                    $(this).parents('div.group').next().css({'display': 'none'});
                }
            }
        );
    }

    function remove()
    {
        $(document).on("click","a.remove_pension",function()
            {
                $(this).parent().remove();
            }
        );
    }


    var CryptoJSAesJson = {
        stringify: function (cipherParams) {
            var j = {ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64)};
            if (cipherParams.iv) j.iv = cipherParams.iv.toString();
            if (cipherParams.salt) j.s = cipherParams.salt.toString();
            return JSON.stringify(j);
        },
        parse: function (jsonStr) {
            var j = JSON.parse(jsonStr);
            var cipherParams = CryptoJS.lib.CipherParams.create({ciphertext: CryptoJS.enc.Base64.parse(j.ct)});
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
            return cipherParams;
        }
    }

    var tempSave = function ($id, $this){

        var vardata         = $( 'form#signup-form').serialize();
        var serializeData   = [];
        $.each($( 'form#signup-form').serializeArray(), function(i, field) {
            if(field.name == 'password' || field.name == 'confirm'){
                //serializeData[this.name] = CryptoJS.AES.encrypt(this.value, phrase);
                serializeData.push(field.name + '='+ CryptoJS.AES.encrypt(JSON.stringify(field.value), phrase, {format: CryptoJSAesJson}).toString());
                //var decrypted = JSON.parse(CryptoJS.AES.decrypt(encrypted, "my passphrase", {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
            }
            else{
                serializeData.push(field.name + '=' + field.value
                    .replace(/&/g, '&amp;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;'));
            }

        });
        //console.log(serializeData.toSource());
        serializeData       = serializeData.join('&');

        $.ajax({
            url: URL,
            method: "POST",
            data: serializeData + '&step=' + $id + '&phrase='+phrase,
            cache: false,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            },
            statusCode: {
                404: function() {
                    alert( "page not found" );
                },
                500: function(){

                }
            },
            beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
        }).fail(function() {
            //alert( "error" );
        }).done(function(data) {
            if(data.status == 500){
                window.location.href = data.url;
            }
            else if(data.status == 0){
                result = 0;
                $('#email').parent().addClass('invalid');
                $('#email').parent().removeClass('valid');
                $('#email').closest(".error").text(data.message);
            }else{
                $('#email').parent().removeClass('invalid');
                $('#email').parent().addClass('valid');
                $('#email').closest(".error").text('');

                $this.closest('.secondary-step').fadeOut('fast',function(){
                    $this.closest('.secondary-step').removeClass('active');
                    $this.closest('.secondary-step').hide();

                }).next().delay(500).fadeIn('fast', function(){
                    if($(this).attr('id') == 'retirement-plan'){
                        $('.next').show();
                    }
                    $(this).addClass('active');
                });
            }
            //$( this ).addClass( "done" );
        });

        //return result;
    }

    var save_signup = function($id){
        var vardata                         = $( 'form#signup-form').serialize();
        var serializeData   = [];
        var phrase          = 'Aasdpl234fdjakspqewrqwcnxsqqwer';
        $.each($( 'form#signup-form').serializeArray(), function(i, field) {
            if(field.name == 'password' || field.name == 'confirm'){
                //serializeData[this.name] = CryptoJS.AES.encrypt(this.value, phrase);
                serializeData.push(field.name + '='+ CryptoJS.AES.encrypt(JSON.stringify(field.value), phrase, {format: CryptoJSAesJson}).toString());
                //var decrypted = JSON.parse(CryptoJS.AES.decrypt(encrypted, "my passphrase", {format: CryptoJSAesJson}).toString(CryptoJS.enc.Utf8));
            }
            else{
                serializeData.push(field.name + '=' + field.value
                        .replace(/&/g, '&amp;')
                        .replace(/"/g, '&quot;')
                        .replace(/'/g, '&#39;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;'));
            }

        });
        //console.log(serializeData.toSource());
        serializeData       = serializeData.join('&');
        var postData        = serializeData
                            + '&step=' + $id
                            + '&phrase=' + phrase
        $.ajax({
            url: signup_save_url,
            method: "POST",
            //data: {"_token": $('input[name=_token]').val()},
            data: postData,
            cache: false,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            },
            statusCode: {
                404: function() {
                    alert( "page not found" );
                }
            },
            beforeSend: function( xhr ) {
                //xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
            }
        }).fail(function (data) {
            alert('fail');
        }).done(function(data) {
            //$( this ).addClass( "done" );
            if(data.status == 500){
                window.location.href = data.url;
            }else if(data.status == 1){
                window.location.href = WELCOME_URL;
            }else{
                $('.message').text(data.message);
            }

        });
    }
});

$.widget('themex.numberOnly', {
    options: {
        valid : "0123456789",
        allow : [46,8,9,27,13,35,39],
        ctrl : [65],
        alt : [],
        extra : []
    },
    _create: function() {
        var self = this;

        self.element.keypress(function(e){
            var pval = (e.which) ? e.which : e.keyCode;
            if(self._codeInArray(e,self.options.allow) || self._codeInArray(e,self.options.extra))
            {
                return;
            }
            if(e.ctrlKey && self._codeInArray(e,self.options.ctrl))
            {
                return;
            }
            if(e.altKey && self._codeInArray(e,self.options.alt))
            {
                return;
            }
            if(!e.shiftKey && !e.altKey && !e.ctrlKey)
            {
                if(self.options.valid.indexOf(String.fromCharCode(pval)) != -1)
                {
                    return;
                }
            }
            e.preventDefault();
        });
    },

    _codeInArray : function(event,codes) {
        for(code in codes)
        {
            if(event.keyCode == codes[code])
            {
                return true;
            }
        }
        return false;
    }

});

/**
 *
 */
$(function(){
    $(".panel-heading-dropdown").css("min-height","65px");
});
/**
 * function to generate fields for assets and liabilities
 * @param type
 * @param count
 */
$(".type-dropdown").change(function(){
    $("#"+$(this).prop("id")+"_add").removeClass("disabled");
});


var al_input = function(type, count){
    $("."+type+"-collapse").each(
        /**
         * (not working) closes the previous accodion item if a new one is added
         */
         function(){
             if($(this).hasClass("in")){
                 $(this).removeClass("in");
                 field_count = 0;
                 $(this).find("input").each(function(){
                     if($(this).val() == ""){
                        field_count++;
                     }
                 });
                 $(this).siblings('.panel-heading').find('.badge').html(field_count+" fields need input");
             }
         }
     );

    /**
     * adds the html fields fo a new item
     */
    $("."+type+"-type-panel").after(
            "<div class='panel panel-default'>"+
            "<div class='panel-heading'>"+
            "<h4 class='panel-title'>"+
            "<a href='javascript:void(0);' class='clear-panel btn btn-warning'>clear</a>&nbsp<a class='"+type+"-title' data-toggle='collapse' data-parent='#"+type+"_accordion' href='#collapse"+count+"'>"+
            "<span class='"+type+"-name'>"+$("#"+type).val()+"</span>"+
            "&nbsp<span class='badge'>7 fields need input</span>"+
            "</a>"+
            "</h4>"+
            "</div>"+
            "<div id='collapse"+count+"' class='"+type+"-collapse panel-collapse collapse in'>"+
            "<div class='panel-body'>"+
            "<div class='field'>"+
            "<label for='company' class='main'>Company:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_company' name='"+type+"["+$("#"+type).val()+"][company]' value='' class='required'>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Balance:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_balance' name='asset["+$("#"+type).val()+"][balance]' value='' class='required numericOnly'>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Funds:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_funds' name='funds' value='' class='required numericOnly'>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Additions:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_additions' name='additions' value=''>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Withdrawals:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_withdrawals' name='withdrawals' value='' class='required numericOnly'>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Interest Rate:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_interest_rate' name='interest_Rate' value='' class='required numericOnly'>"+
            "</div>"+
            "<div class='field'>"+
            "<label for='' class='main'>Beneficiary:</label>"+
            "<input type='text' id='"+$("#"+type).val().replace(/\s+/g, '_')+"_beneficiary' name='beneficiary' value=''>"+
            "</div>"+
            "</div>"+
            "</div>"
    );

    $("#"+$("#"+type).val().replace(/\s+/g, '_')+"_company").focus();

    /**
     * disabling the add button
     */
    $("#"+type+"_add").addClass("disabled");

    /**
     * disables the select option for types that has a field
     */
     $('#'+type+' option:selected').prop("disabled",true);


    /**
     * deletes the liability when the clear link is clicked
     */
    $('.clear-panel').click(
     function(){
             title=$(this).siblings("."+type+"-title").find("."+type+"-name").html();
             $('#'+type+' option').each(function(){
                 if($(this).val()==title){
                    $(this).prop("disabled",false);
                 }
             });
             $(this).parents(".panel").remove();
             $('#'+type).val("0");
         }
     );

    /**
     * updating the panel-heading badge when the form is closed
     */
    $("."+type+"-collapse").on('hide.bs.collapse', function(){
         field_count = 0;
         $(this).find("input").each(function(){
             if($(this).val() == ""){
                field_count++;
             }
         });
         $(this).siblings(".panel-heading").find(".badge").html(field_count+" fields need input");
     });
};


    /**
     * executing the function
     */
    var asset_count = 0;
    var liability_count = 0;
    $("#asset_add").click(function(){
        al_input($("#asset").prop("id"),asset_count++)
    });
    $("#liability_add").click(function(){
        al_input($("#liability").prop("id"),asset_count++)
    });
    /*$("#asset").change(function(){al_input($(this).prop("id"),asset_count++)});

    $("#liability").change(function(){al_input($(this).prop("id"),liability_count++)});*/








