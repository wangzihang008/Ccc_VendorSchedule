/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($){

    // hide messages 
    //$("#error").hide();
    //$("#sent-form-msg").hide();

    // on submit...
    $("#contactForm #submit").click(function() {
        $("#error").hide();

        //required:

        //name
        var name = $("input#name").val();
        if(name == ""){
            $("#error").fadeIn().text("Name required.");
            $("input#name").focus();
            return false;
        }

        // email
        var email = $("input#email").val();
        if(email == ""){
            $("#error").fadeIn().text("Email required");
            $("input#email").focus();
            return false;
        }

        // contact_no
        var contact_no = $("input#contact_no").val();
        if(contact_no == ""){
            $("#error").fadeIn().text("Contact number required");
            $("input#contact_no").focus();
            return false;
        }

        // comments
        var comments = $("#comments").val();


        // data string
        var dataString = 'name='+ name
                        + '&email=' + email        
                        + '&contact_no=' + contact_no
                        + '&comments=' + comments

        // ajax
        $.ajax({
            type:"POST",
            data: dataString,
            success: success()
        });
    });  


    // on success...
     function success(){
        $("#sent-form-msg").fadeIn();
        $("#contactForm").fadeOut();
     }

    return false;
});