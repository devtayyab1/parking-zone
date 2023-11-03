const moment = require('moment');
module.exports = {
    get_booking_confrimation_mail_html: function (data, terminal_data) {
        console.log(data.parking_type, data.company_name);
        return (html_data = `<p>Hi,</p>

       <p><strong>${data.customer_name}</strong>,</p>

       <p>Thank you for booking with Parkingzone, this is your booking confirmation with all your travelling details.</p>

       <p>Please take a print out of this email as you might need to present this at the time of dropping off your vehicle. Please check the details of your booking confirmation as Parkingzone&nbsp; cannot be held responsible if you do not advise amendments required.</p>

       <p>&nbsp;</p>

       <p>If you have any queries feel free to call us on&nbsp; 020 4511 4171&nbsp;or email at&nbsp;<a href="mailto:bookings@parkingzone.co.uk">bookings@parkingzone.co.uk</a></p>
       <p>Telephone: &nbsp; &nbsp; &nbsp; +442045114171 <br></p>

       <p>&nbsp;</p>

       <p>-------------------------------------------------------------------------------------------------------------------------------------</p>

       <p>Booking Detail Confirmation</p>

       <table style="width: 650px;" width="100%" cellspacing="0" cellpadding="0" border="1">
           <tbody>
               <tr>
                   <td width="50%" height="30" align="center">
                   <p><strong>Booking Details</strong></p>

                   <p>${data.referenceNo}</p>

                   <table width="100%" cellspacing="0" cellpadding="0" border="1">
                       <tbody>
                           <tr>
                               <td width="46%" height="30"><strong>&nbsp;Customer Name</strong></td>
                               <td width="54%">&nbsp;${
                                   data.customer_name
                               }  </td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Email</strong></td>
                               <td>&nbsp;${data.customer_email}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Phone</strong></td>
                               <td>&nbsp;${data.customer_phone}</td>
                           </tr>
                           <tr>
                               <td colspan="2">&nbsp;</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Product Name</strong></td>
                               <td>&nbsp;Car Park</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Company Booked with</strong></td>
                               <td>&nbsp;${data.company_name}</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Parking Type</strong></td>
                               <td>&nbsp;${data.parking_type}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Airport&nbsp;</strong></td>
                               <td>&nbsp;${data.airport_name}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Outbound Terminal</strong></td>
                               <td>&nbsp;${
                                   terminal_data.find(
                                       item => item.id == data.deprTerminal
                                   )?.name
                               }</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Inbound Terminal</strong></td>
                               <td>&nbsp;${
                                   terminal_data.find(
                                       item => item.id == data.returnTerminal
                                   )?.name
                               }</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Number Of days</strong></td>
                               <td>&nbsp;${data.no_of_days}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Outbound Date / Time</strong></td>
                               <td>&nbsp;${moment(data.returnDate).format(
                                   'DD-MM-YYYY'
                               )}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Inbound Date / Time</strong></td>
                               <td>&nbsp;${moment(data.departDate).format(
                                   'DD-MM-YYYY'
                               )}</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Booking&nbsp;Date / Time</strong></td>
                               <td>&nbsp;${moment(data.booking_date).format(
                                   'DD-MM-YYYY hh:mm'
                               )}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Inbound Flight No</strong></td>
                               <td>&nbsp;${data?.deptFlight}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Vehicle Registration</strong></td>
                               <td>&nbsp;${data.registration}</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Vehicle Model</strong></td>
                               <td>&nbsp;${data.model}</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp;Vehicle Make</strong></td>
                               <td>&nbsp;${data.make}</td>
                           </tr>
                           <tr>
                               <td height="30">&nbsp;<strong>Vehicle Color</strong></td>
                               <td>&nbsp;${data.color}</td>
                           </tr>
                       </tbody>
                   </table>
                   </td>
                   <td width="50%" valign="top" align="center">
                   <p>&nbsp;</p>

                   <p><strong>Payment Details</strong></p>

                   <table width="100%" cellspacing="0" cellpadding="0" border="0">
                       <tbody>

                           <tr>
                               <td width="40%" height="30"><strong>&nbsp; Booking Ref no:</strong></td>
                               <td width="43%">${data.referenceNo}</td>
                           </tr>
                           <tr>
                               <td><strong>&nbsp; Payment Method</strong></td>
                               <td>stripe</td>
                           </tr>
                           <tr>
                               <td height="30"><strong>&nbsp; Payment Status</strong></td>
                               <td>
                           Success</td>
                           </tr>
                           <tr>
                               <td colspan="2">&nbsp;</td>
                           </tr>
                           <tr>
                               <td>
                               <h2><strong>&nbsp;Amount Paid</strong></h2>
                               </td>
                               <td>
                               <h2><strong>${data.total_amount}</strong></h2>
                               </td>
                           </tr>
                       </tbody>
                   </table>
                   </td>
               </tr>
           </tbody>
       </table>

       <p>&nbsp;</p>

       <p>Note: All amount is charged in pound sterling</p>

       <p>-------------------------------------------------------------------------------------------------------------------------------------</p>

       <h2><strong>Directions:</strong></h2>

       <p>${data.company_guidelines}</p>

       <p>-------------------------------------------------------------------------------------------------------------------------------------</p>

       <p>Terms and Conditions:1</p>

       <p><strong>Terms and Conditions:</strong></p>

       <ol>
           <li><strong>Instructions to be followed prior to parking</strong></li>
           <li value="1">2 You are supposed to carry a copy of the booking confirmation with you at the time when you leave to park your car at the car park and henceforth till the time you retrieve your car back from the &nbsp; &nbsp;car park.</li>
           <li value="1">3 In case you haven’t received your booking confirmation prior to 24 hours of the date of booking, please contact the office on +442045114171&nbsp; or online.</li>
           <li value="1">4 On inquiry you are supposed to present a copy of the booking confirmation and tell the representatives your booking number.</li>
           <li value="1">5 Please ensure that you have a valid identity proof such as Passport, Driving License, Photo ID card, passport etc.</li>
           <li value="1">6 There will be a confirmation sent to you by SMS and you are required to please take a note of it.</li>
           <li value="1">7 Please ensure that the vehicle that you are parking is fully insured.</li>
           <li value="1">8 Please ensure that in case there is a flight to be boarded, the car is dropped off at least 30 minutes prior to the check in time. There won’t be any responsibility of ParkingZone in case a &nbsp; &nbsp;customer misses their flight due to lack of time.</li>
           <li value="1">9 There can be a possible delay during the drop off; the customer should keep scope of that.</li>
           <li value="1">10 Please ensure that the vehicle that you have booked the parking spot for is of a standard size as there will be additional charges incurred for a vehicle larger than the standard size. Please cross &nbsp; check the same with the given parking as there are parking lots which cannot accommodate large vehicles.&nbsp; There are additional charges to be paid for vehicles which are large.</li>
           <li value="1">11 Certain car parks have minimum stays, a customer who wants to stay lesser than the minimum duration will have to pay for the minimum stay. This will be mentioned in the bookings.</li>
           <li value="1">12 There will be airport transfer provided to the customers with prior intimation. In case a customer requires airport transfers they have to mention it at the time of the booking. The airport transfers &nbsp; &nbsp;are without any additional charges.</li>
           <li value="1">13All payments have to be made in advance.</li>
           <li value="2"><strong>Instructions to be followed during parking</strong></li>
           <li value="2">1 Please ensure that there are no valuables left in the car before leaving the car in the car park and the company bears no responsibility for valuables left in the car.</li>
           <li value="2">2 Please leave the car keys with the caretaker unless otherwise specified. Sometimes the car needs to be moved around for the efficient management of parking space so the keys have to remain in the parking.</li>
           <li value="2">3 Please ensure that all the documents of the car are in place.</li>
           <li value="2">4 Please take a copy of the booking confirmation with you once you leave the car park. It acts as a receipt.</li>
           <li value="2">5 Please ensure that you have proper directions to the car park which are different for each car park and mentioned individually.</li>
           <li value="3"><strong>Cancellations and Refunds</strong></li>
           <li value="3.1">1These are only applicable to services which are cancellable/amendable.</li>
           <li value="3">2 Cancellation without a 48-hour notice of the date of service will not be given any refund.</li>
           <li value="3">3 Cancellation done between a 48 hour to one-week period of the date of the service will get a full refund after deducting the booking fees of £10.</li>
           <li value="3">4 All refunds would be processed within 7-10 working days of the cancellation.</li>
           <li value="3">5 The customers are requested to retain the booking confirmation unless the refund is processed.</li>
           <li value="3">6 Under certain offers and promotional schemes no refund would be given. In such a case this clause would be mentioned during the booking.</li>
           <li value="4"><strong>Chauffer Services</strong></li>
           <li value="4">1 In case it is a chauffeur driven service, please ensure that you are present there at the right time.</li>
           <li value="4">2 In case there is a delay there will be additional charges to be paid at the rate of £10 per day payable directly to the Car park.</li>
           <li value="4">3 These additional charges would be payable immediately.</li>
           <li value="5"><strong>Other information</strong></li>
           <li value="5">1 In case of a structural default in a car such as engine fault, dents the Car park won’t be liable. Customers are supposed to check their vehicles for any default in their vehicles.</li>
           <li value="5">2 The owner of the vehicle needs to ensure that the vehicle has a valid insurance policy which does not expire in the course of the parking period.</li>
           <li value="5">3 There are certain car parks which have certain additional costs, the customer should check about these additional costs at the website before booking.</li>
           <li value="6"><strong>Customer Complaints and Grievances</strong></li>
           <li value="6">1 The complaints which are of urgent nature should be taken to the customer service agents who are present at each car park.</li>
           <li value="6">2 Before exiting from the car park, the customer should ensure that everything is in place, once the customer exits from the car park, there won’t be any liability of the Car park</li>
           <li value="6">3 If the complaint is not of an urgent nature, there is a form which is available both online and offline which should be filled by the customer. The Parkingzone&nbsp;&nbsp;limited would get back to the customer &nbsp; &nbsp;in 7-10 working days.&nbsp;</li>
       </ol>

       <p>&nbsp;</p>

       <p><strong>Your statutory rights as a customer will not be effected</strong></p>

       <p><strong>Errors or Omissions Excepted</strong></p>

       <p>-------------------------------------------------------------------------------------------------------------------------------------</p><h3>Try our Hotel Booking service with Best rates. Please click Book Now link to book a <strong>Hotel</strong> with <strong>Parkingzone (Travelez Site)</strong>. <a href="https://www.travelez.co.uk/hotel/"><strong>Book Now</strong></a></h3>

       <p><b>Parkingzone&nbsp;</b><strong>:</strong></p>

       <p>Customer Services: &nbsp; &nbsp;&nbsp;+442045114171&nbsp;</p>

       <p>Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="mailto:bookings@parkingzone.co.uk">bookings@parkingzone.co.uk</a></p>

       <p><b>Parkingzone&nbsp;</b><strong>&nbsp;Limited</strong></p>

       <p>Registered Office: Suite 8F, Kelvin House, Kelvin Way, Crawley West Sussex, United Kingdom RH10 9WE</p>`);
    },
    get_subscription_email_html: function () {
        return (html_data = `<p>Hi ,</p><p><br></p><p>Thank you for choosing Parkingzone You are Successfully subscribed and received 05% coupon code please use this PZ-Og-COUP05" coupon code to avail 05% discount on your booking.</p><p><br></p><p>If you have any queries or require additional information then please call&nbsp;<span class="sc_layouts_item_details sc_layouts_iconed_text_details">+442045114171&nbsp;</span>&nbsp;or email us at bookings@parkingzone.co.uk</p><p><br></p><p>Kind regards </p><p>Parkingzone LTD</p><p>http://Parkingzone.co.uk/<br></p><p><br></p><p>&nbsp;</p><p><br></p><p>&nbsp;</p>`);
    },
    get_new_tikcet_email_html: function (ticket_ref, title, msg, email) {
        return (html_data = `<p><span style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;">&nbsp;A New Reply for support ticket&nbsp;${ticket_ref} has now been Generated.&nbsp;</span></p>

        <p style=""><strong>Title</strong> :&nbsp;</p>
        
        <p style="">${title}</p>
        <p style=""><strong>Reply</strong> :&nbsp;</p>
        
        <p style="">${msg}</p>
        
        <p style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;">You Can View Your Ticket In Mobile App. Open Mobile Application and Open Help disk where you can search for <br>
        Tikcet Ref: ${ticket_ref} & Email: ${email}</p>
        
        <p style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;"><span font-size:="" style="color: rgb(51, 51, 51); font-family: sans-serif, Arial, Verdana, " trebuchet="">______________________________________________________________________________</span></p>
        
        <p><br>
        Kind regards,</p>
        
        <p><strong>ParkingZone</strong></p>
        
        <p>Registered Office: Suite 8F, Kelvin House, Kelvin Way, Crawley West Sussex, United Kingdom RH10 9WE</p>
        
        <p>Registered in England and wales Company Registration Number 11502152</p>
        
        <p>&nbsp;</p>
        
       
        https://www.parkingzone.co.uk/</p>`);
    },
    get_chat_reply_email_html: function (ticket_ref, name, email, message) {
        return (html_data = ` <p><span style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;">&nbsp;A New Reply for support ticket&nbsp;${ticket_ref} has now been Generated.&nbsp;</span></p>

            <p style=""><strong>Reply</strong> :&nbsp;</p>
            
            <p style="">${message}</p>
            
            <p style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;">You Can View Your Ticket By Visiting website or mobile app help disk Page<br>
                Ticket Ref: ${ticket_ref} </p>
               <br> <p style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;"> Email: ${email} </p>
            <p style="color: rgb(80, 80, 80); font-family: Helvetica; font-size: 14px;"><span font-size:="" style="color: rgb(51, 51, 51); font-family: sans-serif, Arial, Verdana, " trebuchet="">______________________________________________________________________________</span></p>
            
            <p><br>
            Kind regards,</p>
            
            <p><strong>ParkingZone</strong></p>
            
            <p>Registered Office: Suite 8F, Kelvin House, Kelvin Way, Crawley West Sussex, United Kingdom RH10 9WE</p>
            
            <p>Registered in England and wales Company Registration Number 11502152</p>
            
            <p>&nbsp;</p>
            https://www.parkingzone.co.uk/</p>`);
    }
};
