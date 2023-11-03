'use strict';

var stripe = Stripe('pk_test_Ze6x0OSDxEwtxQWeOmHKa2ZL');

function registerElements(elements, exampleName) {
    var formClass = '.' + exampleName;
    var example = document.querySelector(formClass);

    var form = example.querySelector('form');
    var resetButton = example.querySelector('a.reset');
    var error = form.querySelector('.error');
    var errorMessage = error.querySelector('.message');

    function enableInputs() {
        Array.prototype.forEach.call(
            form.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel']"
            ),
            function (input) {
                input.removeAttribute('disabled');
            }
        );
    }

    function disableInputs() {
        Array.prototype.forEach.call(
            form.querySelectorAll(
                "input[type='text'], input[type='email'], input[type='tel']"
            ),
            function (input) {
                input.setAttribute('disabled', 'true');
            }
        );
    }

    function triggerBrowserValidation() {
        // The only way to trigger HTML5 form validation UI is to fake a user submit
        // event.
        var submit = document.createElement('input');
        submit.type = 'submit';
        submit.style.display = 'none';
        form.appendChild(submit);
        submit.click();
        submit.remove();
    }

    // Listen for errors from each Element, and show error messages in the UI.
    var savedErrors = {};
    elements.forEach(function (element, idx) {
        element.on('change', function (event) {
            if (event.error) {
                error.classList.add('visible');
                savedErrors[idx] = event.error.message;
                errorMessage.innerText = event.error.message;
            } else {
                savedErrors[idx] = null;

                // Loop over the saved errors and find the first one, if any.
                var nextError = Object.keys(savedErrors)
                    .sort()
                    .reduce(function (maybeFoundError, key) {
                        return maybeFoundError || savedErrors[key];
                    }, null);

                if (nextError) {
                    // Now that they've fixed the current error, show another one.
                    errorMessage.innerText = nextError;
                } else {
                    // The user fixed the last error; no more errors.
                    error.classList.remove('visible');
                }
            }
        });
    });

    // Listen on the form's 'submit' handler...
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Trigger HTML5 validation UI on the form if any of the inputs fail
        // validation.
        var plainInputsValid = true;
        Array.prototype.forEach.call(form.querySelectorAll('input'), function (input) {
            if (input.checkValidity && !input.checkValidity()) {
                plainInputsValid = false;
                return;
            }
        });
        if (!plainInputsValid) {
            triggerBrowserValidation();
            return;
        }

        // Show a loading screen...
        example.classList.add('submitting');

        // Disable all inputs.
        //disableInputs();

        // Gather additional customer data we may have collected in our form.
        var name = form.querySelector('#cc_card_title');

        var additionalData = {
            name: name ? name.value : undefined,

        };

        // Use Stripe.js to create a token. We only need to pass in one Element
        // from the Element group in order to create a token. We can also pass
        // in the additional customer data we collected in our form.
        stripe.createToken(elements[0], additionalData).then(function (result) {
            // Stop loading!
            example.classList.remove('submitting');

            if (result.token) {
                // If we received a token, show the token ID.
                // example.querySelector('.token').innerText = result.token.id;
                // example.classList.add('submitted');


                if ($("#personal_details_form").valid()) {

                    if (valid_address()) {

                        if (validate_vechiledetail()) {

                            var data = {};
                            data['title'] = $('#title').val();
                            data['firstname'] = $('#firstname').val();
                            data['lastname'] = $('#lastname').val();
                            data['email'] = $('#email').val();
                            data['contactno'] = $('#contactno').val();
                            data['action'] = $('#action').val();
                            data['reference_no'] = $('#referenceNo').val();

                            data['_token'] = $('input[name="_token"]').val();
                            data['refr'] = $('#refr').val();
                            //alert(data['refr']);
                            data['booking_id'] = $('#bookID').val();
                            data['alltotal'] = $('#alltotal').val();

                            // if (data['action'] == 'airportParkingBooking') {
//
                            data['company_id'] = $('#bookingDetails input[name="company_id"]').val(),
                                data['parking_type'] = $('#bookingDetails input[name="parking_type"]').val(),
                                data['pickdate'] = $('#bookingDetails input[name="pickdate"]').val(),
                                data['dropdate'] = $('#bookingDetails input[name="dropdate"]').val(),
                                data['droptime'] = $('#bookingDetails input[name="droptime"]').val(),
                                data['picktime'] = $('#bookingDetails input[name="picktime"]').val(),
                                data['total_days'] = $('#bookingDetails input[name="total_days"]').val(),
                                data['airport'] = $('#bookingDetails input[name="airport"]').val(),
                                data['bookingfor'] = $('#bookingDetails input[name="bookingfor"]').val(),
                                data['promo'] = $('#bookingDetails input[name="promo"]').val(),
                                data['smsfee'] = $("#smsfee").val(),
                                data['cancelfee'] = $("#cancelfee").val(),
                                data['passenger'] = $('#passenger').val(),
                                data['incomplete'] = $('#bookingDetails input[name="incomplete"]').val(),
                                data['pl_id'] = $('#bookingDetails input[name="pl_id"]').val(),
                                data['speed_park_active'] = $('#bookingDetails input[name="speed_park_active"]').val(),
                                data['site_codename'] = $('#bookingDetails input[name="site_codename"]').val(),
                                data['sku'] = $('#bookingDetails input[name="sku"]').val(),
                                data['token'] = result.token.id;


                            data['model'] = $('#vechile_detail input[name="model"]').val()
                            data['color'] = $('#vechile_detail input[name="color"]').val()
                            data['make'] = $('#vechile_detail input[name="make"]').val()
                            data['registration'] = $('#vechile_detail input[name="registration"]').val()
                            data['subscribe'] = $('#bookingDetails input[name="subscribe"]').val()
                            data['departterminal'] = $('#departterminal ').val()
                            data['arrivalterminal'] = $('#arrivalterminal').val()
                            data['returnflight'] = $('#returnflight').val()

                            data['address'] = $('#address').val()

                            data['fulladdress'] = $('#getaddress_dropdown option:selected').text()
                            data['address2'] = $('#address2').val()
                            data['town'] = $('#town').val()

                            data['post_code'] = $('#post_code').val()


                            //data['debug']       = 1
                            //}
//
                            $.post('booking/payout', data, function (data) {
                                console.log("data===", data);

                                if (data.success == 0) {
                                    $("#error_personal_detail").html(data.data);
                                }else {
                                    window.location.href = "https://"+window.location.hostname+"/booking/thankyou";

                                }

                            }, 'json');
                        }
                        else {
                            var top = $('#personal_details_form').position().top;
                            $(window).scrollTop(top);
                        }
                    } else {
                        //vechile_detail
                        var top = $('#vechile_detail').position().top;
                        $(window).scrollTop(top);
                    }
                } else {
                    //$("#ad_field").after('<label class="error error-vech" >This field is required.</label>');
                    var top = $('#personal_details_form').position().top;
                    $(window).scrollTop(top);
                }

            } else {
                // Otherwise, un-disable inputs.
                enableInputs();
            }
        });
    });


    resetButton.addEventListener('click', function (e) {
        e.preventDefault();
        // Resetting the form (instead of setting the value to `''` for each input)
        // helps us clear webkit autofill styles.
        form.reset();

        // Clear each Element.
        elements.forEach(function (element) {
            element.clear();
        });

        // Reset error state as well.
        error.classList.remove('visible');

        // Resetting the form does not un-disable inputs, so we need to do it separately:
        enableInputs();
        example.classList.remove('submitted');
    });
}


function submit_payment() {
    $("#firstname").val();
}

function getnerateError(id) {
    var html = '<label id="\'+id+\'-error" class="error" for="' + id + '">This field is required.</label>';
    $("#" + id).after(html);
}