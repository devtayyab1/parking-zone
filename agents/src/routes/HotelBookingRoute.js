var express = require('express');
var db = require('../db/connection');
var HotelBookingRoute = express.Router();
var moment = require('moment');
const request = require('request');
const transporter = require('../db/mail_service');
const { get_booking_confrimation_mail_html } = require('./functions');
var Secret_Key =
    'sk_test_51LlZ1WIZ39EgqF7OgJp7z0uiBF08LryZIK6P9SpMfG5HDIMAbavA3DmKX9hZcr9RhHt9WzKKy3GoFaBRxi8RHXvc00FhZ6glJG';
const stripe = require('stripe')(Secret_Key);
HotelBookingRoute.post('/', function (req, res, next) {
    const booking_info = req.body;
    const book_hash = booking_info?.book_hash; // this is airport id
    const room_name = booking_info?.room_name;
    const hotel_id = booking_info?.hotel_id;
    const hotel_address = booking_info?.hotel_address;
    const hotel_country = booking_info?.hotel_country;

    // user info form
    const title = '';
    const first_name = booking_info?.first_name;
    const last_name = booking_info?.last_name;
    const email = booking_info?.email;
    const phone_number = booking_info?.phone_number;

    // flight details
    const hotel_name = booking_info?.hotel_name;
    const bedding_type = booking_info?.bedding_type;
    const adults = booking_info?.adults;
    const children = booking_info?.children;
    const child1_age = booking_info?.child1_age;
    const child2_age = booking_info?.child2_age;
    const child3_age = booking_info?.child3_age;
    const child4_age = booking_info?.child4_age;
    const citizenship = booking_info?.citizenship;
    const fulladdress = booking_info?.fulladdress;

    const town = booking_info?.town; // discount code
    const postal_code = booking_info?.postal_code; // amount of discount
    const checkindate = booking_info?.checkindate; // actual booking amount
    const checkoutdate = booking_info?.checkoutdate;
    const cancel_date = booking_info?.cancel_date; // this is the fee taking by stripe $1.99
    const is_cancelable = booking_info?.is_cancelable;
    const base_price = booking_info?.base_price;
    const booking_amount = booking_info?.booking_amount;

    /*
     * actual fee submit by user after adding booking_fee ,
     */
    const total_amount = booking_info?.total_amount;
    const intentid = booking_info?.intentid;
    const payment_status = booking_info?.payment_status;

    const booking_status = booking_info?.booking_status;
    const status = booking_info?.status;

    const createAt = moment().format('YYYY-MM-DD HH:mm:ss'); // date and time

    const traffic_src = booking_info?.traffic_src; // value is ORG

    AddCustomer(title, first_name, last_name, email, phone_number)
        .then(customer_id => {
            const lounges_bookings_sql = `INSERT INTO tez_hotel_bookings (book_hash,room_name,hotel_id,hotel_address,hotel_country,hotel_name,bedding_type, adults,children, child1_age,child2_age,child3_age,child4_age,citizenship,first_name,last_name,email,phone_number,fulladdress,town,postal_code,checkindate,checkoutdate,cancel_date,is_cancelable, base_price,booking_amount,total_amount,intent_id,payment_status,booking_status,status,traffic_src,createdate, modifydate) VALUES ('${book_hash}', '${room_name}','${hotel_id}','${hotel_address}','${hotel_country}','${hotel_name}','${bedding_type}', '${adults}', '${children}', '${child1_age}', '${child2_age}','${child3_age}', '${child4_age}','${citizenship}','${first_name}','${last_name}','${email}','${phone_number}','${fulladdress}','${town}','${postal_code}','${checkindate}','${checkoutdate}','${cancel_date}','${is_cancelable}','${base_price}','${booking_amount}','${total_amount}','${intentid}','${payment_status}','${booking_status}','${status}','${traffic_src}','${createAt}','${createAt}')`;
            db.getConnection(function (error, db_query) {
                if (error) {
                    db_query.release();
                    res.status(404).send({ status: false, error: error });
                    return;
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
                            return;
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

HotelBookingRoute.post('/addTransication', function (req, res, next) {
    const id = req.body.id;
    const referenceNo = req.body.referenceNo;
    const sql = `UPDATE tez_hotel_bookings SET payment_status='Successful', booking_status='Completed', referenceNo = '${referenceNo}' WHERE id = '${id}'`;
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

HotelBookingRoute.post('/intent_create', async function (req, res, next) {
    const amount = req.body.amount;
    const currency = req.body.currency;
    var charged;
    try {
        charged = await stripe.paymentIntents.create({
            amount: parseInt(amount * 100),
            currency: currency
        });

        res.status(200).send({
            status: true,
            client_secret: charged.client_secret,
            id: charged.id
        });
    } catch (err) {
        return res.status(500).send({ status: false, message: err });
    }
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
        resolve(data);
    });
};

HotelBookingRoute.get('/', function (req, res, next) {
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

HotelBookingRoute.put('/:id', function (req, res, next) {
    let id = req.params.id;
    const status = req.body.status;

    var sql = `UPDATE tez_hotel_bookings SET booking_status = '${status}' WHERE id = '${id}'`;

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
module.exports = HotelBookingRoute;
