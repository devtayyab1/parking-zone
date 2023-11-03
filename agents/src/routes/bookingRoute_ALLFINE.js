var express = require('express');
var db = require('../db/connection');
var bookingRoute = express.Router();
var moment = require('moment');
var request = require('request');
const transporter = require('../db/mail_service');
bookingRoute.post('/', function (req, res, next) {
    const booking_info = req.body;

    const airportID = booking_info.airportID; // this is airport id
    const companyId = booking_info.companyId; // compnay id
    const product_code = booking_info.product_code; // company product code

    // user info form
    const title = booking_info.title;
    const first_name = booking_info.first_name;
    const last_name = booking_info.last_name;
    const email = booking_info.email;
    const phone_number = booking_info.phone_number;

    // flight details
    const departDate = booking_info.departDate;
    const deprTerminal = booking_info.deprTerminal;
    const deptFlight = booking_info.deptFlight;
    const returnDate = booking_info.returnDate;
    const returnTerminal = booking_info.returnTerminal;
    const returnFlight = booking_info.returnFlight;
    const no_of_days = booking_info.no_of_days;

    const discount_code = booking_info.discount_code; // discount code
    const discount_amount = booking_info.discount_amount; // amount of discount
    const booking_amount = booking_info.booking_amount; // actual booking amount
    const booking_extra = booking_info.booking_extra;
    const extra_amount = booking_info.extra_amount;
    const booking_fee = booking_info.booking_fee; // this is the fee taking by stripe $1.99

    const cancelfee = booking_info.cancelfee;
    const leavy_fee = booking_info.leavy_fee;
    /*
     * actual fee submit by user after adding booking_fee ,
     */
    const total_amount = booking_info.total_amount;
    const booking_status = booking_info.booking_status;
    const booking_action = booking_info.booking_action;
    const payment_status = booking_info.payment_status;
    const PayerID = booking_info.PayerID; // payment Intent Id
    const status = booking_info.status;
    const booked_type = booking_info.booked_type;
    const browser_data = booking_info.browser_data; // this is null
    const email_status = booking_info.email_status; // valis is  No
    const sms_status = booking_info.sms_status; // valus is No
    const payment_method = booking_info.payment_method; // stripe
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time
    const email_respond = booking_info.email_respond;
    const removed = booking_info.removed; // value is always No
    const parent_id = booking_info.parent_id; // value is always zero
    const traffic_src = booking_info.traffic_src; // value is ORG

    const agentID = booking_info.agentID; /// its value of PZ is always 3
    const user_ip = booking_info.user_ip; // user ip Address
    const incomplete_email = booking_info.incomplete_email; // can be 0 and 1
    const mailchip_email = booking_info.mailchip_email; // value is 1
    /*
     * booking info of the user
     */

    const make = booking_info.make;
    const color = booking_info.color;
    const model = booking_info.model;
    const registration = booking_info.registration;
    const park_api = booking_info.park_api; // general
    AddCustomer(title, first_name, last_name, email, phone_number)
        .then(customer_id => {
            const airport_bookings_sql = `INSERT INTO airports_bookings (airportID, companyId, customerId, product_code,title,first_name, last_name, email, phone_number,departDate, deprTerminal, deptFlight,returnDate, returnTerminal,returnFlight, no_of_days, discount_code,discount_amount, booking_amount, booking_extra,extra_amount,booking_fee, cancelfee, leavy_fee, total_amount,booking_status,booking_action,payment_status, PayerID, createdate, modifydate,status,booked_type,browser_data, email_status,sms_status,payment_method,email_respond, removed,parent_id, traffic_src, agentID, user_ip,incomplete_email,mailchip_email,make, color,model,registration, park_api, updated_at, created_at,passenger) VALUES ('${airportID}', '${companyId}','${customer_id}','${product_code}','${title}', '${first_name}', '${last_name}', '${email}', '${phone_number}', '${departDate}', '${deprTerminal}', '${deptFlight}', '${returnDate}', '${returnTerminal}', '${returnFlight}', '${no_of_days}', '${discount_code}', '${discount_amount}', '${booking_amount}', '${booking_extra}', '${extra_amount}','${booking_fee}', '${cancelfee}', '${leavy_fee}', '${total_amount}', '${booking_status}','${booking_action}','${payment_status}','${PayerID}','${createAt}','${createAt}','${status}', '${booked_type}', '${browser_data}','${email_status}','${sms_status}', '${payment_method}', '${email_respond}', '${removed}', '${parent_id}', '${traffic_src}', '${agentID}', '${user_ip}', ${incomplete_email}, '${mailchip_email}', '${make}','${color}', '${model}', '${registration}', '${park_api}', '${createAt}','${createAt}', '1')`;
            db.getConnection(function (error, db_query) {
                if (error) {
                    db_query.release();
                    res.status(404).send({ status: false, error: error });
                }
                db_query.query(
                    airport_bookings_sql,
                    function (error, results, fields) {
                        if (error) {
                            db_query.release();
                            res.status(404).send({
                                status: false,
                                error: error
                            });
                        }
                        db_query.release();
                        res.status(200).send({
                            status: true,
                            message: 'Booking created successfully',
                            data: results
                        });
                    }
                );
            });
        })
        .catch(err => {
            res.status(404).send({ status: false, message: 'Booking Failed' });
        });
});

const AddCustomer = (title, first_name, last_name, email, phone_number) => {
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss');
    return new Promise((resolve, reject) => {
        const find_sql = `SELECT * FROM customers WHERE email = '${email}' LIMIT 1`;
        db.getConnection(function (error, db_query) {
            if (error) {
                db_query.release();
                reject({ status: false, error: error });
            }
            db_query.query(find_sql, function (error, results, fields) {
                if (error) {
                    db_query.release();
                    reject({ status: false, error: error });
                }
                if (results.length > 0) {
                    db_query.release();
                    resolve(results[0].id);
                } else {
                    var insert_sql = `INSERT INTO customers (title, first_name, last_name, email, phone_number, password, status, added_on, update_on, updated_at, created_at) VALUES ( '${title}', '${first_name}', '${last_name}', '${email}','${phone_number}', '3c716fae47220b2a2883be5fdf34d992','Yes', '${createAt}', '${createAt}', '${createAt}', '${createAt}')`;
                    db_query.query(
                        insert_sql,
                        function (error, results_insert, fields) {
                            if (error) {
                                db_query.release();
                                reject({ status: false, error: error });
                            }
                            db_query.release();
                            resolve(results_insert.insertId);
                        }
                    );
                }
            });
        });
    });
};

bookingRoute.post('/addTransication', function (req, res, next) {
    const booking_info = req.body;
    const park_api = booking_info.park_api;
    const companyId = booking_info.companyId; // compnay id
    const referenceNo = booking_info.referenceNo; // company referenceNo code
    const orderID = booking_info.orderID; // this is booking ID
    const discount_amount = booking_info.discount_amount; // amount of discount
    const booking_amount = booking_info.booking_amount; // actual booking amount
    const no_of_days = booking_info.no_of_days;
    const extra_amount = booking_info.extra_amount;
    const booking_fee = booking_info.booking_fee; // this is the fee taking by stripe $1.99
    const amount_type = booking_info.amount_type;
    const cancelfee = booking_info.cancelfee;

    const smsfee = booking_info.smsfee;
    const payable = booking_info.payable;
    /*
     * actual fee submit by user after adding booking_fee ,
     */
    const total_amount = booking_info.total_amount;
    const booking_status = booking_info.booking_status;
    const PayerID = booking_info.PayerID; // payment Intent Id
    const payment_method = booking_info.payment_method; // stripe
    const payment_action = booking_info.payment_action;
    const payment_case = booking_info.payment_case;
    const payment_medium = booking_info.payment_medium;
    const palenty_to = booking_info.palenty_to;
    const palenty_amount = booking_info.palenty_amount;
    const comments = booking_info.comments;
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time

    if (park_api == 'global') {
        const body = {
            key: 'fsemmmp8kkt78eof',
            sku: `${booking_info.product_code}`,
            payment_type: 'stripe',
            amount: `${total_amount}`,
            discount: `${discount_amount}`,
            transaction_id: `${orderID}`,
            valet_charges: `${booking_info.valet_charges}`,
            extra_charges: `${booking_info.extra_charges}`,
            levy_charges: `${booking_info.levy_charges}`,
            make: `${booking_info.make}`,
            model: `${booking_info.model}`,
            color: `${booking_info.color}`,
            registration: `${booking_info.registration}`,
            name: `${booking_info.first_name} ${booking_info.last_name}`,
            email: `${booking_info.email}`,
            contact_no: `${booking_info.phone_number}`,
            reference: `${referenceNo}`,
            status: '1',
            departure_date: `${booking_info.departure_date}`,
            departure_time: `${booking_info.departure_time}`,
            departure_terminal: `${booking_info.departure_terminal}`,
            departure_flight_no: `${booking_info.departure_flight_no}`,
            arrival_date: `${booking_info.arrival_date}`,
            arrival_time: `${booking_info.arrival_time}`,
            arrival_terminal: `${booking_info.arrival_terminal}`,
            arrival_flight_no: `${booking_info.arrival_flight_no}`,
            num_people: `${booking_info.passenger}`
        };
        SaveGloableBooking(body)
            .then(data => {
                const booking_update_query = `UPDATE airports_bookings SET  ext_ref = '${referenceNo}', referenceNo = '${referenceNo}', booking_status = 'Completed', booking_action = 'Booked', payment_status = 'done' WHERE id = '${orderID}'`;
                const transication_sql = `INSERT INTO booking_transaction (companyId, edit_by, orderID, referenceNo, token, discount_amount, booking_amount, extra_amount, smsfee, booking_fee, cancelfee, total_amount, payable, amount_type, payment_method, payment_action, payment_case, payment_medium, palenty_amount, palenty_to, booking_status, comments, modifydate) VALUES  ('${companyId}', '0', '${orderID}', '${referenceNo}', '${PayerID}', '${discount_amount}', '${booking_amount}', '${extra_amount}', '${smsfee}', '${booking_fee}', '${cancelfee}', '${total_amount}', '${payable}', '${amount_type}', '${payment_method}', '${payment_action}', '${payment_case}', '${payment_medium}', '${palenty_amount}', '${palenty_to}', '${booking_status}', '${comments}', '${createAt}')`;
                db.getConnection(function (error, db_query) {
                    if (error) {
                        db_query.release();
                        res.status(404).send({ status: false, error: error });
                    }
                    try {
                        db_query.query(
                            booking_update_query,
                            function (error, results, fields) {
                                if (error) {
                                    db_query.release();
                                    res.status(404).send({
                                        status: false,
                                        error: error
                                    });
                                }
                                try {
                                    db_query.query(
                                        transication_sql,
                                        function (error, results, fields) {
                                            if (error) {
                                                db_query.release();
                                                res.status(404).send({
                                                    status: false,
                                                    error: error
                                                });
                                            }
                                            db_query.release();
                                            res.status(200).send({
                                                status: true,
                                                message:
                                                    'Transication against booking created successfully',
                                                body: body,
                                                data: results
                                            });
                                        }
                                    );
                                } catch (error) {
                                    db_query?.release();
                                    res.status(404).send({
                                        status: false,
                                        error: error
                                    });
                                }
                            }
                        );
                    } catch (error) {
                        db_query?.release();
                        res.status(404).send({ status: false, error: error });
                    }
                });
            })
            .catch(err => {
                res.status(404).send({ status: false, error: err });
            });
    } else if (park_api == 'APH') {
        const formData = {
            ArrivalDate: `${moment(booking_info.departure_date).format(
                'DDMMMYY'
            )}`,
            DepartDate: `${moment(booking_info.arrival_date).format(
                'DDMMMYY'
            )}`,
            ArrivalTime: `${booking_info.arrival_time.replace(':', '')}`,
            DepartTime: `${booking_info.departure_time.replace(':', '')}`,
            no_of_days: no_of_days,
            companycode: `${booking_info.product_code}`,
            product_code: `${booking_info.product_code}`,
            passenger: '1',
            returnFlight: '82345',
            terminal: 'TBA',
            rterminal: 'TBA',
            make: `${booking_info.make}`,
            model: `${booking_info.model}`,
            color: `${booking_info.color}`,
            registration: `${booking_info.registration}`,
            title: `${booking_info.tilte}`,
            first_name: `${booking_info.first_name}`,
            last_name: `${booking_info.last_name}`,
            email: `${booking_info.email}`,
            phone_number: `${booking_info.phone_number}`,
            action: 'AphBookingOrderMobile'
        };

        SaveAPHBOOKIng(formData)
            .then(data_booking_aph_dd => {
                let data_booking_aph = JSON.parse(data_booking_aph_dd);
                if (data_booking_aph.BookingRef !== null) {
                    const booking_update_query = `UPDATE airports_bookings SET  ext_ref = '${data_booking_aph.BookingRef}', referenceNo = '${referenceNo}', booking_status = 'Completed', booking_action = 'Booked', payment_status = 'done' WHERE id = '${orderID}'`;
                    const transication_sql = `INSERT INTO booking_transaction (companyId, edit_by, orderID, referenceNo, token, discount_amount, booking_amount, extra_amount, smsfee, booking_fee, cancelfee, total_amount, payable, amount_type, payment_method, payment_action, payment_case, payment_medium, palenty_amount, palenty_to, booking_status, comments, modifydate) VALUES  ('${companyId}', '0', '${orderID}', '${referenceNo}', '${PayerID}', '${discount_amount}', '${booking_amount}', '${extra_amount}', '${smsfee}', '${booking_fee}', '${cancelfee}', '${total_amount}', '${payable}', '${amount_type}', '${payment_method}', '${payment_action}', '${payment_case}', '${payment_medium}', '${palenty_amount}', '${palenty_to}', '${booking_status}', '${comments}', '${createAt}')`;
                    db.getConnection(function (error, db_query) {
                        if (error) {
                            db_query.release();
                            res.status(404).send({
                                status: false,
                                error: error
                            });
                        }
                        try {
                            db_query.query(
                                booking_update_query,
                                function (error, results, fields) {
                                    if (error) {
                                        db_query.release();
                                        res.status(404).send({
                                            status: false,
                                            error: error
                                        });
                                    }
                                    try {
                                        db_query.query(
                                            transication_sql,
                                            function (error, results, fields) {
                                                if (error) {
                                                    db_query.release();
                                                    res.status(404).send({
                                                        status: false,
                                                        error: error
                                                    });
                                                }
                                                db_query.release();
                                                res.status(200).send({
                                                    status: true,
                                                    message:
                                                        'Transication against booking created successfully',
                                                    body: data_booking_aph,
                                                    data: results
                                                });
                                            }
                                        );
                                    } catch (error) {
                                        db_query?.release();
                                        res.status(404).send({
                                            status: false,
                                            error: error
                                        });
                                    }
                                }
                            );
                        } catch (error) {
                            db_query?.release();
                            res.status(404).send({
                                status: false,
                                error: error
                            });
                        }
                    });
                } else {
                    res.send({
                        status: true,
                        message: 'Booking Not Done',
                        data: data_booking_aph,
                        error: 'There is some issue with aph booking api, response'
                    });
                }
            })
            .catch(err => {
                res.send({
                    status: false,
                    message: 'Booking Not Done',
                    data: formData,
                    error: err
                });
            });
    } else {
    }
});

const SaveGloableBooking = body => {
    return new Promise((resolve, reject) => {
        var options = {
            method: 'POST',
            url: 'https://globalparkingmanagement.co.uk/api/bookings/supplierStore',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(body)
        };
        request(options, function (error, response) {
            if (error) reject(error);
            let json_res = JSON.parse(response.body);

            if (json_res.success) {
                resolve(json_res);
            } else {
                reject(json_res);
            }
        });
    });
};

const SaveAPHBOOKIng = formData => {
    console.log(formData, 'formDDDDD');
    return new Promise((resolve, reject) => {
        var options = {
            method: 'POST',
            url: 'https://www.parkingzone.co.uk/api/api_booking_functions.php',
            headers: {
                'Content-Type': ''
            },
            formData: formData
        };
        request(options, function (error, response) {
            console.log(error, 'Errororororororoorororororoororororororor');
            if (error) reject(error);
            console.log(
                response.body,
                'response.bodyresponse.bodyresponse.body'
            );
            resolve(response.body);
        });
    });
};

bookingRoute.get('/', function (req, res, next) {
    var email = req.query.email_address;
    var booking_reference = req.query.booking_reference;
    var last_name = req.query.last_name;
    var sql = `SELECT * FROM airports_bookings as ab LEFT JOIN companies ON ab.companyId = companies.id    LEFT JOIN booking_transaction as bt ON ab.referenceNo = bt.referenceNo    WHERE email = '${email}' AND ab.last_name = '${last_name}' AND ab.referenceNo = '${booking_reference}'  LIMIT 1`;
    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
        }
        db.query(sql, function (error, results, fields) {
            if (error) {
                db_query.release();
                res.status(404).send({ status: false, error: error });
            }
            db_query.release();
            if (results.length > 0) {
                res.status(200).send({
                    status: true,
                    data: results[0]
                });
            } else {
                res.status(404).send({
                    status: false,
                    error: 'Sorry, Please check your email, last name and booking reference carefully'
                });
            }
        });
    });
});

const sendEmail = () => {
    var mailOptions = {
        from: 'pz@parkingzone.co.uk',
        to: 'engr.aftabufaq@gmail.com',
        subject: 'Parkingzone Confirmation Booking',
        html: `<p>Hi,</p><p><strong>[username]</strong>,</p>`
    };
    transporter.sendMail(mailOptions, function (error, info) {
        if (error) {
            res.status(404).send({
                status: false,
                message: 'Your email is failed',
                error: error
            });
        } else {
            res.send({
                status: true,
                message: 'I am sending mail',
                data: info.response
            });
        }
    });
};
bookingRoute.put('/:id', function (req, res, next) {
    let id = req.params.id;
    const status = req.body.status;

    var sql = `UPDATE airports_bookings SET booking_status = '${status}' WHERE id = '${id}'`;

    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
        }
        db_query.query(sql, function (error, results, fields) {
            if (error) {
                db_query.release();
                res.status(404).send({ status: false, error: error });
            }
            db_query.release();
            res.status(200).send({
                status: true,
                data: results
            });
        });
    });
});
module.exports = bookingRoute;
