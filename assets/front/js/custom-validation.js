$(document).ready(function(){$("#frm_contact").validate({errorPlacement:function(e,t){return!0},rules:{txt_name:{minlength:2,required:!0},txt_email:{required:!0,email:!0},txt_phone:{required:!0},txt_message:{minlength:2,required:!0}},submitHandler:function(e){return $.ajax({url:"email/contact-email-process.php",data:$("#frm_contact").serialize(),type:"POST",success:function(e){"sent"==e?$("#result_msg").html("<div class='col-sm-12 text-center alert alert-success'>Thank you for contacting us. We will be in touch with you soon.</div>"):$("#result_msg").html("<div class='col-sm-12 text-center alert alert-danger'>We are sorry, but there appears to be a problem with the form you submitted.</div>")}}),!1}}),$("#frm_booking").validate({errorPlacement:function(e,t){return!0},rules:{txt_first_name:{minlength:2,required:!0},txt_email:{required:!0,email:!0},txt_phone:{required:!0},txt_arrival_date:{required:!0},txt_departure_date:{required:!0},txt_adults:{required:!0},txt_message:{minlength:2,required:!0}},submitHandler:function(e){return $.ajax({url:"email/booking-email-process.php",data:$("#frm_booking").serialize(),type:"POST",success:function(e){"sent"==e?$("#result_msg").html("<div class='col-sm-12 text-center alert alert-success'>Thank you for contacting us. We will be in touch with you soon.</div>"):$("#result_msg").html("<div class='col-sm-12 text-center alert alert-danger'>We are sorry, but there appears to be a problem with the form you submitted.</div>")}}),!1}})});