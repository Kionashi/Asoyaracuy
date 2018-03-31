<script>
    jQuery(document).ready(function(){

        $("<?php echo $validator['selector']; ?>").validate({
            highlight: function (element) { 
                // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); 
            },
            unhighlight: function (element) { 
                // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
            },
            invalidHandler: function(event, validator) {
                // Active tab with error
                $('.language-tabs li').removeClass('active');
                $('.tab-pane').removeClass('active');
                $('#parent_'+$(validator.errorList[0].element).closest('.tab-pane').attr('id')).addClass('active');
                $(validator.errorList[0].element).closest('.tab-pane').addClass('active');
            },
            errorElement: 'span', 
            errorClass: 'help-block help-block-error',
            focusInvalid: false, 
            ignore: ".ignore",  
            errorPlacement: function(error, element) {
                // Prints custom error messages
                if (element.attr("type") == "checkbox" || element.attr("type") == "radio" ) {
                    error.insertAfter(element.parents('div').find('.radio-list'));
                } else {
                    if(element.attr('type') == 'file') { 
                        error.insertAfter(element.parent());
                    } else if(element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else if (element.get(0).tagName == 'SELECT'){
                        if(element.hasClass('multi-select')) {
                            error.insertAfter(element.closest('.multi-select'));
                        } else {
                            error.insertAfter(element.closest('.select2').parent());
                        }
                    } else if(element.hasClass('control-ckeditor')){
                        error.insertAfter(element.next().next());
                    }else{
                        error.insertAfter(element);
                    }
                }
            },
            success: function (label) {
                // Set success class to the control group                
                label.closest('.form-group').removeClass('has-error').addClass('has-success'); 
            },
            
            submitHandler: function(form) {
                $(':submit, #submit').attr('disabled', 'disabled');
                return true; 
            },            
            
            rules: <?php echo json_encode($validator['rules']); ?> 
        });
    });
</script>