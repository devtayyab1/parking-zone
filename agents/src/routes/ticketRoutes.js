var express = require('express');
var ticketRoute = express.Router();
var db = require('../db/connection');
var moment = require('moment');
const transporter = require('../db/mail_service');
const {
    get_new_tikcet_email_html,
    get_chat_reply_email_html
} = require('./functions');
ticketRoute.post('/', function (req, res, next) {
    var referenceNo = req.body.booking_ref;
    var email = req.body.email;
    var last_name = req.body.name;
    var ticket_id = req.body.ticket_id;
    var title = req.body.title;
    var contact = req.body.contact;
    var department = req.body.department;
    var urgency = req.body.urgency;
    var title = req.body.title;
    var ticket_message = req.body.ticket_message;
    var attachment = req.body.file;
    var booking_type = req.body.booking_type;
    var booking_sql = null;
    if (booking_type == 'airport_parking') {
        booking_sql = `SELECT * FROM airports_bookings WHERE referenceNo = '${referenceNo}'`;
    } else if (booking_type == 'hotel_booking') {
        booking_sql = `SELECT * FROM tez_hotel_bookings WHERE referenceNo = '${referenceNo}'`;
    } else if (booking_type == 'lounge_booking') {
        booking_sql = `SELECT * FROM lounges_bookings WHERE referenceNo = '${referenceNo}'`;
    } else if (booking_type == 'transfer_booking') {
        booking_sql = `SELECT * FROM transfer_bookings WHERE referenceNo = '${referenceNo}'`;
    } else {
        res.status(404).send({ status: false, error: 'Reference not found' });
        return;
    }

    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
            return;
        }
        db_query.query(booking_sql, function (error, results, fields) {
            if (error) {
                db_query.release();
                res.status(404).send({ status: false, error: error });
                return;
            }
            if (results.length > 0) {
                let booking_data = results[0];

                if (last_name == booking_data.last_name) {
                    if (email == booking_data.email) {
                        db.getConnection(function (error, db_q) {
                            if (error) {
                                db_q.release();
                                res.status(404).send({
                                    status: false,
                                    error: error
                                });
                            }
                            var sql = `INSERT INTO tickets (ticket_id, title, booking_ref, user_id, company_admin_id, name, email, contact, department, urgency, date, assign_to, assign_date, status) 
                            VALUES ('${ticket_id}', '${title}','${referenceNo}','${
                                booking_data.customerId
                            }','1','${last_name}', '${email}', '${contact}','${department}','${urgency}','${moment().format(
                                'YYYY-MM-DD HH:mm:ss'
                            )}','1','${moment().format(
                                'YYYY-MM-DD HH:mm:ss'
                            )}','Open')`;
                            db_q.query(sql, function (error, results, fields) {
                                // If some error occurs, we throw an error.
                                if (error) {
                                    db_q.release();
                                    res.status(404).send({
                                        status: false,
                                        error: error.sqlMessage
                                    });
                                }
                                db_q.release();
                                let update_sql = `UPDATE tickets SET ticket_id = 'PZT${moment().format(
                                    'DMMYY'
                                )}${results.insertId}'  WHERE tickets.id = '${
                                    results.insertId
                                }'`;

                                db.getConnection(function (error, db_uq) {
                                    if (error) {
                                        db_uq.release();
                                        res.status(404).send({
                                            status: false,
                                            error: error
                                        });
                                    }
                                    db_uq.query(
                                        update_sql,
                                        function (error, upresults, fields) {
                                            // If some error occurs, we throw an error.
                                            if (error) {
                                                db_uq.release();
                                                res.status(404).send({
                                                    status: false,
                                                    error: error.sqlMessage
                                                });
                                            }
                                            db_uq.release();
                                            var chat_sql = `INSERT INTO ticket_chats (id, ticket_id, message, attachment, clientunread, adminunread, Companyread, replyingtime, replyingadmin, reply_by, reply_to, hold, users_beep) VALUES (NULL, '${results.insertId}', '${ticket_message}', '${attachment}', 'No', 'Yes', 'No', '2022-09-21 16:21:00.000000', '1', 'Client', 'All', 'Yes', '')`;

                                            db.getConnection(function (
                                                error,
                                                db_chat
                                            ) {
                                                if (error) {
                                                    db_chat.release();
                                                    res.status(404).send({
                                                        status: false,
                                                        error: error
                                                    });
                                                }

                                                db_chat.query(
                                                    chat_sql,
                                                    function (
                                                        error,
                                                        chat_results,
                                                        fields
                                                    ) {
                                                        // If some error occurs, we throw an error.
                                                        if (error) {
                                                            db_chat.release();
                                                            res.status(
                                                                404
                                                            ).send({
                                                                status: false,
                                                                error: error.sqlMessage
                                                            });
                                                        }
                                                        db_chat.release();
                                                        GetDetailsByTicketId(
                                                            `PZT${moment().format(
                                                                'DMMYY'
                                                            )}${
                                                                results.insertId
                                                            }`
                                                        )
                                                            .then(data => {
                                                                res.status(
                                                                    200
                                                                ).send({
                                                                    status: true,
                                                                    data: data
                                                                });
                                                                sendEmailNewTikcet(
                                                                    data.ticket_ref,
                                                                    data.title,
                                                                    ticket_message,
                                                                    email
                                                                );
                                                            })
                                                            .catch(err => {
                                                                res.status(
                                                                    404
                                                                ).send(err);
                                                            });
                                                    }
                                                );
                                            });
                                        }
                                    );
                                });
                            });
                        });
                    } else {
                        db_query.release();
                        res.status(404).send({
                            status: false,
                            error: 'Booking with email does not found. Please check carefully'
                        });
                    }
                } else {
                    db_query.release();
                    res.status(404).send({
                        status: false,
                        error: 'Booking with last name does not found . Please check carefully'
                    });
                }
            } else {
                db_query.release();
                res.status(404).send({
                    status: false,
                    error: 'Booking refrenece does not exists. Please check carefully'
                });
            }
        });
    });
});

const sendEmailNewTikcet = (ticket_ref, title, msg, email) => {
    var mailOptions = {
        from: 'pz@parkingzone.co.uk',
        to: `${email}`,
        subject: `New Reply For Ticket ID : ${ticket_ref}`,
        html: get_new_tikcet_email_html(ticket_ref, title, msg, email)
    };
    transporter.sendMail(mailOptions, function (error, info) {
        if (error) {
            console.log(error);
        } else {
            console.log('Senddd');
        }
    });
};

const sendEmailForTikcetReply = (id, ticket_message) => {
    var sql = `SELECT name, email,ticket_id FROM tickets WHERE id = '${id}' LIMIT 1`;
    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
            return;
        }
        db_query.query(sql, function (error, results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_query.release();
                console.log(error.sqlMessage);
                return;
            }
            db_query.release();
            var mailOptions = {
                from: 'pz@parkingzone.co.uk',
                to: `${results[0].email}`,
                subject: `New Reply For Ticket ID : ${results[0].ticket_id}`,
                html: get_chat_reply_email_html(
                    results[0].ticket_id,
                    results[0].name,
                    results[0].email,
                    ticket_message
                )
            };
            transporter.sendMail(mailOptions, function (error, info) {
                if (error) {
                    console.log(error);
                } else {
                    console.log('Senddd');
                }
            });
        });
    });
};
ticketRoute.post('/tikcetreply', function (req, res, next) {
    const ticket_id = req.body.ticket_id;
    const ticket_message = req.body.message;
    const attachment = req.body.attachment;
    const createdAt = moment().format('YYYY-MM-DD HH:mm:ss.SSSSS');
    var chat_sql = `INSERT INTO ticket_chats (ticket_id, message, attachment, clientunread, adminunread, Companyread, replyingtime, replyingadmin, reply_by, reply_to, hold, users_beep) VALUES 
    ('${ticket_id}', '${ticket_message}', '${attachment}', 'No', 'Yes', 'No', '${createdAt}', '1', 'Client', 'All', 'Yes', '')`;

    db.getConnection(function (error, db_chat) {
        if (error) {
            db_chat.release();
            res.status(404).send({
                status: false,
                error: error
            });
            return;
        }

        db_chat.query(chat_sql, function (error, chat_results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_chat.release();
                res.status(404).send({
                    status: false,
                    error: error.sqlMessage
                });
                return;
            }
            db_chat.release();
            res.status(200).send({
                status: true,
                message: 'your message has been send successfully'
            });
            sendEmailForTikcetReply(ticket_id, ticket_message);
        });
    });
});

ticketRoute.get('/', function (req, res, next) {
    var email = req.query.email;
    var ticket_Reference = req.query.ticket_Reference;
    var sql = `SELECT t.ticket_id as ticket_ref , t.* , tc.* FROM tickets t LEFT JOIN ticket_chats  tc ON t.id = tc.ticket_id  WHERE t.ticket_id = '${ticket_Reference}' AND t.email = '${email}'`;
    db.getConnection(function (error, db) {
        if (error) {
            res.status(404).send({ status: false, error: error });
            return;
        }
        db.query(sql, function (error, results, fields) {
            if (error) {
                res.status(404).send({ status: false, error: error });
                return;
            }
            if (results.length > 0) {
                res.status(200).send({
                    status: true,
                    data: filterResults(results)
                });
            } else {
                res.status(404).send({
                    status: false,
                    data: 'Sorry, Please check your email and tikect reference carefully'
                });
            }
        });
    });
});

const GetDetailsByTicketId = ticket_Reference => {
    return new Promise((resolve, reject) => {
        var sql = `SELECT t.ticket_id as ticket_ref , t.* , tc.* FROM tickets t LEFT JOIN ticket_chats  tc ON t.id = tc.ticket_id  WHERE t.ticket_id = '${ticket_Reference}'`;
        db.getConnection(function (error, db_get) {
            if (error) {
                db_get.release();

                reject({ status: false, error: error });
                return;
            }
            db_get.query(sql, function (error, results, fields) {
                if (error) {
                    db_get.release();
                    reject({ status: false, error: error });
                    return;
                }
                db_get.release();
                resolve(filterResults(results));
            });
        });
    });
};

const filterResults = data => {
    let my_obj = {
        chat: []
    };
    data.forEach((item, index) => {
        my_obj.id = item.id;
        my_obj.ticket_ref = item.ticket_ref;
        my_obj.ticket_id = item.ticket_id;
        my_obj.title = item.title;
        my_obj.booking_ref = item.booking_ref;
        my_obj.user_id = item.user_id;
        my_obj.company_admin_id = item.company_admin_id;
        my_obj.name = item.name;
        my_obj.contact = item.contact;
        my_obj.department = item.department;
        my_obj.urgency = item.urgency;
        my_obj.date = item.date;
        my_obj.assign_to = item.assign_to;
        my_obj.status = item.status;
        my_obj.email = item.email;
        my_obj.chat.push({
            id: item.id,
            ticket_id: item.ticket_id,
            message: item.message, // "this is a message to all of you",
            attachment: item.attachment, // "public/images/1.png",
            clientunread: item.clientunread, //"No",
            adminunread: item.adminunread, //"Yes",
            Companyread: item.Companyread, // "No",
            replyingtime: item.replyingtime, // "2022-09-21T11:21:00.000Z",
            replyingadmin: item.replyingadmin, // 1,
            reply_by: item.reply_by, // "Client",
            reply_to: item.reply_to, // "All",
            hold: item.hold, // "Yes",
            users_beep: item.users_beep // ""
        });
    });

    return my_obj;
};

module.exports = ticketRoute;
