var express = require('express');
var db = require('../db/connection');
var TransferBookingRoute = express.Router();
var moment = require('moment');
const request = require('request');
const transporter = require('../db/mail_service');
const { get_booking_confrimation_mail_html } = require('./functions');
TransferBookingRoute.post('/', function (req, res, next) {
    const booking_info = req.body;

    // user info form
    const title = booking_info?.title;
    const first_name = booking_info?.first_name;
    const last_name = booking_info?.last_name;
    const email = booking_info?.email;
    const phone_number = booking_info?.phone_number;

    // flight details
    const transfer_id = booking_info?.transfer_id;
    const transfer_name = booking_info?.transfer_name;
    const transfer_code = booking_info?.transfer_code;
    const referenceNo_ext = booking_info?.referenceNo_ext;
    const referenceLink_ext = booking_info?.referenceLink_ext;
    const referenceNo = booking_info?.referenceNo;
    const arrival_date = booking_info?.arrival_date;
    const arrival_time = booking_info?.arrival_time;
    const return_date = booking_info?.return_date;
    const return_time = booking_info?.return_time;
    const adults = booking_info?.adults;
    const infants = booking_info?.infants;
    const children = booking_info?.children;

    // location information

    const loc_type = booking_info?.loc_type;
    const loc_code = booking_info?.loc_code;
    const loc_name = booking_info?.loc_name;
    const loc_lat = booking_info?.loc_lat;
    const loc_long = booking_info?.loc_long;
    const loc_id = booking_info?.loc_id;
    const loc_country = booking_info?.loc_country;
    const loc_type_drop = booking_info?.loc_type_drop;
    const loc_code_drop = booking_info?.loc_code_drop;
    const loc_name_drop = booking_info?.loc_name_drop;
    const loc_lat_drop = booking_info?.loc_lat_drop;
    const loc_long_drop = booking_info?.loc_long_drop;
    const loc_id_drop = booking_info?.loc_id_drop;
    const loc_country_drop = booking_info?.loc_country_drop;

    const discount_amount = booking_info?.discount_amount; // amount of discount
    const booking_amount = booking_info?.booking_amount; // actual booking amount
    const extra_amount = booking_info?.extra_amount;
    const smsfee = booking_info?.smsfee;
    const postal_fee = booking_info?.postal_fee;
    const booking_fee = booking_info?.booking_fee; // this is the fee taking by stripe $1.99
    const cancelfee = booking_info?.cancelfee;

    const total_amount = booking_info?.total_amount;
    const currency_allowed = booking_info?.currency_allowed;
    const booking_status = booking_info?.booking_status;
    const booking_action = booking_info?.booking_action;
    const payment_status = booking_info?.payment_status;
    const PayerID = booking_info?.PayerID; // payment Intent Id
    const status = booking_info?.status;
    const api_res = booking_info?.api_res; // valis is  No
    const payment_method = booking_info?.payment_method; // stripe
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time
    const token = booking_info?.token;

    const booked_type = booking_info?.booked_type;
    const traffic_src = booking_info?.traffic_src; // value is OR
    const email_status = booking_info?.email_status; /// its value of PZ is always 3
    const email_respond = booking_info?.email_respond; // user ip Address
    const removed = booking_info?.removed; /// its value of PZ is always 3
    const lounge_available = booking_info?.lounge_available; /// its value of PZ is always 3
    const intent_id = booking_info?.intent_id; // user ip Address

    /*
     * booking info of the user
     */

    AddCustomer(title, first_name, last_name, email, phone_number)
        .then(customer_id => {
            const lounges_bookings_sql = `INSERT INTO transfer_bookings (customerId ,title, first_name, last_name, email,phone_number,transfer_id,transfer_name,transfer_code, referenceNo_ext, referenceLink_ext, referenceNo,arrival_date,arrival_time,return_date,return_time,loc_type,loc_code,loc_name,loc_lat,loc_long,loc_id,loc_country,loc_type_drop,loc_code_drop,loc_name_drop,loc_lat_drop,loc_long_drop,loc_id_drop,loc_country_drop,discount_amount,booking_amount,extra_amount,smsfee,postal_fee,booking_fee,cancelfee,total_amount,currency_allowed,booking_status,booking_action,payment_status,PayerID,status,api_res, payment_method,  token,booked_type,traffic_src, email_status,email_respond,removed, lounge_available,intent_id,createdate,modifydate,adults,infants,children) VALUES ('${customer_id}', '${title}', '${first_name}','${last_name}','${email}','${phone_number}','${transfer_id}','${transfer_name}', '${transfer_code}', '${referenceNo_ext}', '${referenceLink_ext}', '${referenceNo}','${arrival_date}', '${arrival_time}','${return_date}','${return_time}','${loc_type}','${loc_code}','${loc_name}', '${loc_lat}','${loc_long}','${loc_id}','${loc_country}','${loc_type_drop}','${loc_code_drop}','${loc_name_drop}','${loc_lat_drop}','${loc_long_drop}','${loc_id_drop}','${loc_country_drop}','${discount_amount}','${booking_amount}','${extra_amount}','${smsfee}','${postal_fee}','${booking_fee}','${cancelfee}','${total_amount}','${currency_allowed}','${booking_status}','${booking_action}','${payment_status}','${PayerID}','${status}','${api_res}','${payment_method}','${token}','${booked_type}','${traffic_src}','${email_status}','${email_respond}','${removed}','${lounge_available}','${intent_id}','${createAt}','${createAt}','${adults}','${infants}','${children}')`;
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

TransferBookingRoute.post('/addTransication', function (req, res, next) {
    const booking_info = req.body;

    // user info form
    const transferID = booking_info?.transferID;
    const edit_by = booking_info?.edit_by;
    const orderID = booking_info?.orderID;
    const referenceNo = booking_info?.referenceNo;
    const token = booking_info?.token;
    const discount_amount = booking_info?.discount_amount; // amount of discount
    const booking_amount = booking_info?.booking_amount; // actual booking amount
    const extra_amount = booking_info?.extra_amount;
    const smsfee = booking_info?.smsfee;
    const booking_fee = booking_info?.booking_fee; // this is the fee taking by stripe $1.99
    const cancelfee = booking_info?.cancelfee;
    const total_amount = booking_info?.total_amount;
    const payable = booking_info?.payable;
    const amount_type = booking_info?.amount_type;
    const payment_method = booking_info?.payment_method;
    const payment_action = booking_info?.payment_action;
    const payment_case = booking_info?.payment_case;
    const payment_medium = booking_info?.payment_medium;
    const palenty_amount = booking_info?.palenty_amount;
    const palenty_to = booking_info?.palenty_to;
    const comments = booking_info?.comments;
    const booking_status = booking_info?.booking_status;
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time
    SaveBooking({})
        .then(data => {
            const sql_trans = `INSERT INTO transfer_transaction (transferID,edit_by, orderID, referenceNo, token,  discount_amount, booking_amount, extra_amount, smsfee, booking_fee, cancelfee, total_amount, payable, amount_type, payment_method, payment_action, payment_case, payment_medium, palenty_amount, palenty_to, comments, modifydate, booking_status, added_on) VALUES ('${transferID}','${edit_by}', '${orderID}', '${referenceNo}', '${token}', '${discount_amount}', '${booking_amount}', '${extra_amount}', '${smsfee}', '${booking_fee}', '${cancelfee}', '${total_amount}', '${payable}', '${amount_type}', '${payment_method}', '${payment_action}', '${payment_case}', '${payment_medium}', '${palenty_amount}', '${palenty_to}', '${comments}', '${createAt}', '${booking_status}', '${createAt}');`;
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
                    const update_sql = `UPDATE transfer_bookings SET booking_status = 'Completed', booking_action = 'Abandon', payment_status = 'Success' WHERE transfer_bookings.id = ${orderID}`;
                    db_query.query(
                        update_sql,
                        function (error, results, fields) {
                            if (error) {
                                db_query.release();
                                res.status(404).send({
                                    status: false,
                                    error: error
                                });
                                return;
                            }

                            db_query.release();
                            res.status(200).send({
                                status: true,
                                api_holiday_response: data,
                                data: results
                            });
                        }
                    );
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
};

module.exports = TransferBookingRoute;
