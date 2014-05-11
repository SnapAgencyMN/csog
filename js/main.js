$(function() {
  /* Section Slider for Questions. */
  $('.question_header').click(function() {
    var target = $(this).next(".question_set_wrapper");
    if(target.hasClass("hidden"))
    {
      $(this).addClass("question_header_open");
      target.slideDown("Slow", function() {
        target.removeClass("hidden");
      });
    }
    else
    {
      $(this).removeClass("question_header_open");
      target.slideUp("Slow", function() {
        target.addClass("hidden");
      });
    }
  });

/*
  $('input[type="checkbox"]').change(function() {
    if(this.checked && $(this).hasClass("has_children")) {
      $(this).parent().children().removeClass('hidden');
    }
    else if(!this.checked && $(this).hasClass("has_children")) {
      $(this).parent().children().not(".has_children").addClass('hidden');
    }
  });

  $('.question_set_submit').click(function(event){
    event.preventDefault();
    var $form = $(this).parents('form:first');
    var sData = $form.serialize();

    request = $.ajax({
      url: "/php/modifyRecords.php",
      type: "post",
      data: sData
    });

    request.done(function (response, textStatus, jqXHR){
    });

    request.fail(function (jqXHR, textStatus, errorThrown) {
      console.error("Error: "+ textStatus, errorThrown);
    });
  });
  */
  $('#contact-form-projects').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#contact-form-projects').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });
  
    var errors = 0;

    if($.trim(values['name']) == "")
    {
      $('#contact-form-name-div').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['message']) == "")
    {
      $('#contact-form-message-div').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['email']) == "")
    {
      $('#contact-form-email-div').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    } 
    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($.trim(values['email'])) && $.trim(values['email']) != "")
    {
      $('#contact-form-email').after("<div class='formError'>Please enter a valid email.</div>");
      errors = 1;
    }

    if(errors == 0)
    {
      $.ajax({
       url: "/php/contactForm.php",
        data: $('#contact-form-projects').serialize(),
        type: 'POST',
        success: function(data) {
          $('#contact-form-projects').html("<div><h3>Thank You</h3><p>We will get back to you as soon as possible.</p></div>");
        }
      });     

    }
    event.preventDefault();
  });

  $('#resetPasswordForm').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#resetPasswordForm').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });
    $.ajax({
    url: "/php/resetPassword.php",
      data: $('#resetPasswordForm').serialize(),
      type: 'POST',
      success: function(data) {
        $('#resetPasswordForm').html("<div><p>If this email exists, you will recieve a password reset link.</p></div>");
      }
    });     

    event.preventDefault();
  });

  $('#resetPasswordVerifyForm').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#resetPasswordVerifyForm').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });
    
    var errors = 0;
    if($.trim(values['password']) == "")
    {
      $('#resetPasswordPassword').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) == "")
    {
      $('#resetPasswordPasswordConfirm').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) != $.trim(values['password']) && $.trim(values['passwordConfirm']) != "")
    {
      $('#resetPasswordPassword').after("<div class='formError'>Passwords must match.</div>");
      errors = 1;
    }

    $.ajax({
    url: "/php/resetPasswordVerify.php",
      data: $('#resetPasswordVerifyForm').serialize(),
      type: 'POST',
      success: function(data) {
        $('#resetPasswordVerifyForm').html("<div><p>Your password has been reset.</p></div>");
        alert(data);
      }
    });     

    event.preventDefault();
  });

  /* Modify user form input validation */
  $('#generalModifyForm').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#generalModifyForm').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });

    var errors = 0;

    if($.trim(values['name']) == "")
    {
      $('#modifyFormName').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['companyName']) == "")
    {
      $('#modifyFormCompanyName').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if(errors == 1)
    {
      event.preventDefault();
    }
  });

  /* update password form input validation */
  $('#passwordModifyForm').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#passwordModifyForm').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });

    var errors = 0;

    if($.trim(values['password']) == "")
    {
      $('#passwordFormPassword').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) == "")
    {
      $('#passwordFormConfirmPassword').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) != $.trim(values['password']) && $.trim(values['passwordConfirm']) != "")
    {
      $('#passwordFormConfirmPassword').after("<div class='formError'>Passwords must match.</div>");
      errors = 1;
    }

    if(errors == 1)
    {
      event.preventDefault();
    }
  });



  /* Register form input validation */
  $('#registerForm').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#registerForm').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });

    var errors = 0;

    if($.trim(values['name']) == "")
    {
      $('#registerFormName').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['mailingAddress']) == "")
    {
      $('#registerFormMailingAddress').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['city']) == "")
    {
      $('#registerFormCity').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['state']) == "")
    {
      $('#registerFormState').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['zip']) == "")
    {
      $('#registerFormZip').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['website']) == "")
    {
      $('#registerFormWebsite').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['phoneNumber']) == "")
    {
      $('#registerFormPhoneNumber').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['companyName']) == "")
    {
      $('#registerFormCompanyName').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['email']) == "")
    {
      $('#registerFormEmail').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    } 
    if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($.trim(values['email'])) && $.trim(values['email']) != "")
    {
      $('#registerFormEmail').after("<div class='formError'>Please enter a valid email.</div>");
      errors = 1;
    } else
    {
      $.get( "../php/userTest.php?email="+ $.trim(values['email']), function( data ) {
        if( data == "1" )
        {
          $('#registerFormEmail').after("<div class='formError'>This email is all ready registered.</div>");
          errors = 1;
        }
      });
    }
    if($.trim(values['emailConfirm']) == "")
    {
      $('#registerFormConfirmEmail').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['emailConfirm']) != $.trim(values['email']) && $.trim(values['emailConfirm']) != "")
    {
      $('#registerFormConfirmEmail').after("<div class='formError'>Emails must match.</div>");
      errors = 1;
    }
    if($.trim(values['username']) == "")
    {
      $('#registerFormUsername').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    } else
    {
      $.get( "../php/userTest.php?username="+ $.trim(values['username']), function( data ) {
        if( data == "1" )
        {
          $('#registerFormUsername').after("<div class='formError'>This username is not available.</div>");
          errors = 1;
        }
      });
    }
    if($.trim(values['password']) == "")
    {
      $('#registerFormPassword').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) == "")
    {
      $('#registerFormConfirmPassword').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if($.trim(values['passwordConfirm']) != $.trim(values['password']) && $.trim(values['passwordConfirm']) != "")
    {
      $('#registerFormConfirmPassword').after("<div class='formError'>Passwords must match.</div>");
      errors = 1;
    }



    if(errors == 1)
    {
      event.preventDefault();
    }
  });


  /* Register form input validation */
  $('#new-project-form').submit(function( event ) {
    $('.formError').remove();
    var values = {};
    $.each($('#new-project-form').serializeArray(), function(i, field) {
      values[field.name] = field.value;
    });
    errors = 0;

    if($.trim(values['projectName']) == "")
    {
      $('#newProjectName').after("<div class='formError'>This field is required.</div>");
      errors = 1;
    }
    if(errors == 1)
    {
      event.preventDefault();
    }
  });

  /* Load template for editing question when switching templates */
  $('#question_edit_template').change(function() {
    $('#template_section').remove();
    $('.template_seperator').after().load("http://" + window.location.hostname + "/php/editTemplates.php?template=" + $('#question_edit_template').val());
  });

  $('.addMore').click(function() {
      var id = $(this).attr('value');
      $('.counterInput_'+id).val(parseInt($('.counterInput_'+id).val()) + 1).change();
      location.reload();
  });
  $('.removeOne').click(function() {
      var id = $(this).attr('value');
      $('.counterInput_'+id).val(parseInt($('.counterInput_'+id).val()) - 1).change();
      location.reload();
  });
   

  /* Handles saving all non-file upload questions for main forms */
  /*
  $('.form_question').change(function() {
    var question = this;
    var questionParent = $(this).closest('.question_set_row_field');
    var repeating = "false";
    var repeatCount = 0;
    if ($("#questionRepeat").length > 0){
      repeating = $('.repeater').attr("name").slice(2,-3)
      repeatCount =  $('.repeater').val();
    }
   

    var qID = $(this).attr("name").split("[");
    var qID = qID[0].split("_");
    var qID = qID[1];
//    var qID = $(this).attr("name").slice(2,-3);

    //var pID = $('#projIdent').val().toString()

    var questionID = $(this).attr("class").split(/\s+/);
    var textValues = $("input[name^='"+questionID[0]+"\\[']:not(:radio):not(:checkbox):not(:file)").map(function(){return $(this).val();}).get();

    var checkedValues = $("input[name^='"+questionID[0]+"']:checked").map(function(){return $(this).val();}).get();

    //alert("checkedValues: "+checkedValues);
    //alert("textValues: "+textValues); 
    
    $.ajax({
      url: "/php/save.php",
      data: {qID:qID,pID:pID,qDataText:textValues,qDataChecked:checkedValues,repeating:repeating,repeatCount:repeatCount},
      type: 'POST',
      success: function(data) {
//        alert(data);
        if($(question).hasClass("repeater"))
        {
          location.reload();
        }
      }
    });

    


  });
*/
});

function submitForm(id)
{
    $("#"+id).submit();
}

function updateRow(id, type, otherID)
{
    // Reveal all children
    $("#"+type+"_question_row_"+id+" .child").each(function( i ) {
        
        var id = $(this).attr('id');
        var idArray = id.split("_");
        var parentID = idArray[1];
        
        var categoryType = $(this).attr('category_type');
        
        var answer = $("#"+categoryType+"_"+parentID);
        var answerType = answer.attr('type');     
        
        var display = false;
        if (answerType == 'radio' || answerType == 'checkbox')
        {
            if (answer.is(':checked'))
            {
                var display = true;
            }
        }
        else if(answerType == 'text')
        {
            if (answer.val() != "")
            {
                var display = true;
            }
        }
        
        if (display)
        {
            $(this).removeClass("hidden");
        }
        else
        {
            $(this).addClass("hidden");
        }
    });
    
    // Check if unknown is used
    if ($("#"+type+"_question_row_"+id+" .unknown").length > 0 )
    {
        var categoryType = $("#"+type+"_question_row_"+id+" .unknown").attr('category_type');
        
        if ($("#"+type+"_question_row_"+id+" [name='unknown_"+categoryType+"_"+id+"']").is(":checked"))
        {
            $("#"+type+"_question_row_"+id+" div.question_answers:not(.unknown)").each(function( i ) {
                $(this).addClass('hidden');
            });
        }
        else
        {
            $("#"+type+"_question_row_"+id+" div.question_answers:not(.unknown)").each(function( i ) {
                $(this).removeClass("hidden");
            });
        }
    }
    
    // Hide others that are not used
    if ($.type(otherID) != "undefined")
    {
        // Remove if input is empty
        var input = $("#other_"+otherID+"_"+type+"_"+id);
        var questionID = input.attr( "question_id" );

        if (input.val() === "")
        {
            input.parent().parent().next().remove();
            input.parent().parent().remove();
        }
        
        //Recount all others left
        $("input[question_id="+questionID+"][question_type='other'][div_type='"+type+"']").each(function( i ) {
            var seqNum = i+1;
            var newInput = "other_"+seqNum+"_"+type+"_"+id;
            $(this).attr("name", newInput);
            $(this).attr("id", newInput);
            $(this).attr("onblur", "updateRow("+id+", '"+type+"', "+seqNum+")");
            
            $(this).parent().parent().attr('id',"other_"+seqNum+"_"+type+"_question_row_"+id);
        });

    }
}

function addNewOtherBox(questionID, type, intent, url, hint, title)
{
    var numOfOthers = $("input[question_id="+questionID+"][question_type='other'][div_type='"+type+"']").size();
    
    // Change latest one to input
    var div = $("input[question_id="+questionID+"][question_type='other'][div_type='"+type+"']").last().parent();
    var newInput = "<input div_type='"+type+"' question_type='other' question_id='"+questionID+"' onblur=\"updateRow("+questionID+", '"+type+"', "+numOfOthers+")\" type='text' name='other_"+numOfOthers+"_"+type+"_"+questionID+"' id='other_"+numOfOthers+"_"+type+"_"+questionID+"' class='form_question' />";
    div.html(newInput);

    // Add new checkbox one
    var newSeqNum = numOfOthers+1;
    var newCheckbox = "<div class='question_set_row' id='other_"+newSeqNum+"_"+type+"_question_row_"+questionID+"'>";
    newCheckbox += "<div style='padding-left:"+intent+"' class='question_set_row_hint'>";
        newCheckbox += "<img src='"+url+"/media/hint.png' alt='Hint' title=\""+hint+"\">";
    newCheckbox += "</div>";
    newCheckbox += "<div class='question_set_row_title'>"+title+"</div>";
    newCheckbox += "<div class='question_set_row_field'>";
    newCheckbox += "<input div_type='"+type+"' question_type='other' question_id='"+questionID+"' onclick=\"addNewOtherBox("+questionID+", '"+type+"', '"+intent+"', '"+url+"', '"+hint+"', '"+title+"'); return false;\" type='checkbox' name='other_"+newSeqNum+"_"+type+"_"+questionID+"' id='other_"+newSeqNum+"_"+type+"_"+questionID+"' class='form_question checkbox' />"
    newCheckbox += "</div></div><div class='clear'></div>";
    div.parent().parent().append(newCheckbox);
    
}

function updateSpawn(categoryID, host)
{
    var value = $('#spawn_'+categoryID).val();
    
    $.ajax({
        url: host+"ajaxHandler.php",
        data:"action=save_spawn_input&categoryID=" + categoryID + "&value="+value,
        dataType: "text",
        success: function(data, textStatus, jqXHR){
            location.reload();
        },
        error:function(err){
            alert(err);
        }
    });
}