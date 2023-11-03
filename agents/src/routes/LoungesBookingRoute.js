var express = require('express');
var db = require('../db/connection');
var LoungesbookingRoute = express.Router();
var moment = require('moment');
const request = require('request');
const transporter = require('../db/mail_service');
const { get_booking_confrimation_mail_html } = require('./functions');
LoungesbookingRoute.post('/', function (req, res, next) {
    const booking_info = req.body;
    const airportID = booking_info?.airportID; // this is airport id
    const airport_code = booking_info?.airport_code;
    const lounge_id = booking_info?.lounge_id;
    const lounge_name = booking_info?.lounge_name;
    const lounge_code = booking_info?.lounge_code;

    // user info form
    const title = booking_info?.title;
    const first_name = booking_info?.first_name;
    const last_name = booking_info?.last_name;
    const email = booking_info?.email;
    const phone_number = booking_info?.phone_number;

    // flight details
    const passenger = booking_info?.passenger;
    const additional_pass_details = booking_info?.additional_pass_details;
    const referenceNo = booking_info?.referenceNo;
    const referenceNo_ext = booking_info?.referenceNo_ext;
    const referenceLink_ext = booking_info?.referenceLink_ext;
    const check_in = booking_info?.check_in;
    const check_in_time = booking_info?.check_in_time;
    const adults = booking_info?.adults;
    const infants = booking_info?.infants;
    const children = booking_info?.children;

    const discount_code = booking_info?.discount_code; // discount code
    const discount_amount = booking_info?.discount_amount; // amount of discount
    const booking_amount = booking_info?.booking_amount; // actual booking amount
    const extra_amount = booking_info?.extra_amount;
    const booking_fee = booking_info?.booking_fee; // this is the fee taking by stripe $1.99
    const smsfee = booking_info?.smsfee;
    const postal_fee = booking_info?.postal_fee;
    const cancelfee = booking_info?.cancelfee;

    /*
     * actual fee submit by user after adding booking_fee ,
     */
    const total_amount = booking_info?.total_amount;
    const currency_allowed = booking_info?.currency_allowed;
    const booking_status = booking_info?.booking_status;
    const booking_action = booking_info?.booking_action;
    const payment_status = booking_info?.payment_status;
    const PayerID = booking_info?.PayerID; // payment Intent Id
    const status = booking_info?.status;
    const email_status = booking_info?.email_status; // valis is  No

    const payment_method = booking_info?.payment_method; // stripe
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time
    const email_respond = booking_info?.email_respond;
    const removed = booking_info?.removed; // value is always No

    const traffic_src = booking_info?.traffic_src; // value is ORG

    const lounge_available = booking_info?.lounge_available; /// its value of PZ is always 3
    const intent_id = booking_info?.intent_id; // user ip Address

    /*
     * booking info of the user
     */

    AddCustomer(title, first_name, last_name, email, phone_number)
        .then(customer_id => {
            const lounges_bookings_sql = `INSERT INTO lounges_bookings (airportID, airport_code, lounge_id, lounge_name,lounge_code,customerId,title,first_name, last_name, email, phone_number,passenger,additional_pass_details,referenceNo,referenceNo_ext,referenceLink_ext,check_in,check_in_time,adults,infants,children,discount_code,discount_amount,booking_amount,extra_amount,smsfee,postal_fee,booking_fee,cancelfee,total_amount,currency_allowed,booking_status,booking_action,payment_status,PayerID,status,email_status,payment_method,email_respond,removed,traffic_src,lounge_available,intent_id,createdate,modifydate) VALUES ('${airportID}', '${airport_code}','${lounge_id}','${lounge_name}','${lounge_code}','${customer_id}','${title}', '${first_name}', '${last_name}', '${email}', '${phone_number}','${passenger}', '${additional_pass_details}','${referenceNo}','${referenceNo_ext}','${referenceLink_ext}','${check_in}','${check_in_time}','${adults}','${infants}','${children}','${discount_code}','${discount_amount}','${booking_amount}','${extra_amount}','${smsfee}','${postal_fee}','${booking_fee}','${cancelfee}','${total_amount}','${currency_allowed}','${booking_status}','${booking_action}','${payment_status}','${PayerID}','${status}','${email_status}','${payment_method}','${email_respond}','${removed}','${traffic_src}','${lounge_available}','${intent_id}','${createAt}','${createAt}')`;
            db.getConnection(function (error, db_query) {
                if (error) {
                    db_query.release();
                    res.status(404).send({ status: false, error: error });
                }
                db_query.query(
                    lounges_bookings_sql,
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

LoungesbookingRoute.post('/addTransication', function (req, res, next) {
    const booking_info = req.body;
    const loungeID = booking_info?.loungeID;
    const edit_by = booking_info?.edit_by; // compnay id
    const orderID = booking_info?.orderID; // company referenceNo code

    const token = booking_info?.token; // amount of discount
    const discount_amount = booking_info?.discount_amount; // actual booking amount
    const booking_amount = booking_info?.booking_amount;
    const extra_amount = booking_info?.extra_amount;
    const smsfee = booking_info?.smsfee;
    const booking_fee = booking_info?.booking_fee; // this is the fee taking by stripe $1.99
    const cancelfee = booking_info?.cancelfee;
    const total_amount = booking_info?.total_amount;

    const payable = booking_info?.payable;
    const amount_type = booking_info?.amount_type;

    const payment_method = booking_info?.payment_method; // stripe
    const payment_action = booking_info?.payment_action;
    const payment_case = booking_info?.payment_case;
    const payment_medium = booking_info?.payment_medium;
    const palenty_to = booking_info?.palenty_to;
    const palenty_amount = booking_info?.palenty_amount;
    const comments = booking_info?.comments;
    const booking_status = booking_info?.booking_status;
    const product_code = booking_info?.code;
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time
    let obj = {
        product_code: product_code,
        ArrivalTime: booking_info?.check_in_time,
        ArrivalDate: booking_info?.check_in,
        Adults: booking_info?.adults,
        Children: booking_info?.children,
        Title: booking_info?.title,
        Initial: booking_info?.first_name,
        Surname: booking_info?.last_name
    };
    SaveBooking(obj)
        .then(data => {
            const sql_trans = `INSERT INTO lounges_transaction (id, loungeID, edit_by, orderID, referenceNo, token, discount_amount, booking_amount, extra_amount, smsfee, booking_fee, cancelfee, total_amount, payable, amount_type, payment_method, payment_action, payment_case, payment_medium, palenty_amount, palenty_to, comments, modifydate, booking_status, added_on) VALUES (NULL, '${loungeID}', '${edit_by}', '${orderID}', '${data.BookingRef}', '${token}', '${discount_amount}', '${booking_amount}', '${extra_amount}', '${smsfee}', '${booking_fee}', '${cancelfee}', '${total_amount}', '${payable}', '${amount_type}', '${payment_method}', '${payment_action}', '${payment_case}', '${payment_medium}', '${palenty_amount}', '${palenty_to}', '${comments}', '${createAt}', '${booking_status}', '${createAt}');`;
            db.getConnection(function (error, db_query) {
                if (error) {
                    db_query.release();
                    res.status(404).send({ status: false, error: error });
                    return;
                }
                db_query.query(sql_trans, function (error, results, fields) {
                    if (error) {
                        db_query.release();
                        res.status(404).send({ status: false, error: error });
                        return;
                    }
                    db_query.release();
                    res.status(200).send({
                        status: true,
                        api_holiday_response: data,
                        data: results
                    });
                });
            });
        })
        .catch(err => {
            res.status(404).send({
                status: false,
                error: err,
                message: 'There is some error with the server'
            });
        });
});

const sendEmailToConfrimBooking = booking_id => {
    const sql_data = `SELECT  ab.airportID, ab.deprTerminal,ab.returnTerminal,ab.deptFlight, ab.referenceNo, CONCAT(ab.first_name, " ", ab.last_name) as customer_name,booking_transaction.total_amount, ab.email as customer_email, ab.phone_number as customer_phone, companies.name as company_name, CONCAT(companies.overview , " ", companies.arival, " ", companies.return_proc ) as company_guidelines, airports.name as airport_name, companies.parking_type, ab.returnDate,ab.departDate, ab.no_of_days, ab.registration, ab.make, ab.model, ab.color, ab.created_at as booking_date FROM lounges_bookings ab LEFT JOIN booking_transaction ON ab.referenceNo = booking_transaction.referenceNo LEFT JOIN companies ON companies.company_code = booking_transaction.companyId LEFT JOIN airports on ab.airportID = airports.id  WHERE ab.id = '${booking_id}' LIMIT 1 `;
    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
        }
        db_query.query(sql_data, function (error, results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_query.release();
                console.log(error.sqlMessage);
                return;
            }
            var sql_airport = `SELECT * FROM airports_terminals  WHERE aid = '${results[0].airportID}'`;
            db_query.query(
                sql_airport,
                function (error, sql_airport_results, fields) {
                    // If some error occurs, we throw an error.
                    if (error) {
                        db_query.release();
                        console.log(error.sqlMessage);
                        return;
                    }
                    db_query.release();
                    var mailOptions = {
                        from: 'pz@parkingzone.co.uk',
                        to: `${results[0].customer_email}`,
                        subject: 'Parkingzone Confirmation Booking',
                        html: get_booking_confrimation_mail_html(
                            results[0],
                            sql_airport_results
                        )
                    };
                    transporter.sendMail(mailOptions, function (error, info) {
                        if (error) {
                            console.log(error);
                        } else {
                            console.log('Senddd');
                        }
                    });
                }
            );
        });
    });
};

const SaveBooking = data => {
    return new Promise((resolve, reject) => {
        resolve({ BookingRef: 'TEST_IAIAIAIAIA' });
    });
    //     var options = {
    //         method: 'POST',
    //         url: `https://api.holidayextras.co.uk/v1/lounge/${data.product_code}.js`,
    //         headers: {
    //             'Content-Type': 'application/x-www-form-urlencoded'
    //         },
    //         form: {
    //             token: '829152491',
    //             key: 'parkingzone',
    //             ABTANumber: 'AJ166',
    //             Password: 'PAXML',
    //             Initials: 'p',
    //             ...data
    //         }
    //     };

    //     request(options, function (error, response) {
    //         if (error) reject(error);
    //         try {
    //             let myres = JSON.parse(response.body);
    //             console.log(JSON.stringify(myres), 'myresmyresmyres');
    //             if (myres.API_Reply.ATTRIBUTES.Result == 'OK') {
    //                 resolve(myres.API_Reply.Booking);
    //             } else {
    //                 reject({
    //                     ...myres.API_Reply.Error,
    //                     data: options
    //                 });
    //             }
    //         } catch (err) {
    //             reject(response.body);
    //         }
    //     });
    // });
};

LoungesbookingRoute.get('/', function (req, res, next) {
    var email = req.query.email_address;
    var booking_reference = req.query.booking_reference;
    var last_name = req.query.last_name;
    var sql = `SELECT * FROM lounges_bookings as ab LEFT JOIN companies ON ab.companyId = companies.id    LEFT JOIN booking_transaction as bt ON ab.referenceNo = bt.referenceNo    WHERE email = '${email}' AND ab.last_name = '${last_name}' AND ab.referenceNo = '${booking_reference}'  LIMIT 1`;
    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
            return;
        }
        db.query(sql, function (error, results, fields) {
            if (error) {
                db_query.release();
                res.status(404).send({ status: false, error: error });
                return;
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

LoungesbookingRoute.put('/:id', function (req, res, next) {
    let id = req.params.id;
    const status = req.body.status;

    var sql = `UPDATE lounges_bookings SET booking_status = '${status}' WHERE id = '${id}'`;

    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
            return;
        }
        db_query.query(sql, function (error, results, fields) {
            if (error) {
                db_query.release();
                res.status(404).send({ status: false, error: error });
                return;
            }
            db_query.release();
            res.status(200).send({
                status: true,
                data: results
            });
        });
    });
});
module.exports = LoungesbookingRoute;
