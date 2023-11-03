var express = require('express');
var subscribeRoute = express.Router();
var moment = require('moment');
const db = require('../db/connection.js');
const { get_subscription_email_html } = require('./functions.js');
const transporter = require('../db/mail_service');
subscribeRoute.post('/', function (req, res, next) {
    let email = req.body.email;
    let ip = req.body.ip;
    const createAt = moment().format('YYYY-MM-DD HH:mm:ss');
    var sql = `SELECT * FROM subscribers WHERE email = '${email}' LIMIT 1`;
    db.getConnection(function (err, db_find) {
        if (err) {
            db_find.release();
            res.status(404).send({ status: false, error: err.message });
            return;
        }
        // Executing the MySQL query (select all data from the 'users' table).
        db_find.query(sql, function (error, results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_find.release();
                res.status(404).send({
                    status: false,
                    error: error.sqlMessage
                });
                return;
            }
            if (results.length > 0) {
                db_find.release();
                res.status(200).send({
                    status: false,
                    message: 'This email already subscribed'
                });
            } else {
                var insert_sql = `INSERT IGNORE INTO subscribers (name, email, airport_id, source, download, ip, email_frequency,subs_date, removed) VALUES ('${(
                    Math.random() + 1
                )
                    .toString(36)
                    .substring(
                        7
                    )}', '${email}', '0', 'MOBILE', 'No', '${ip}', 'Weekly','${createAt}', 'No')`;
                db.getConnection(function (err, db_insert) {
                    if (err) {
                        db_insert.release();
                        res.status(404).send({
                            status: false,
                            error: err.message
                        });
                        return;
                    }
                    // Executing the MySQL query (select all data from the 'users' table).
                    db_insert.query(
                        insert_sql,
                        function (error, results, fields) {
                            // If some error occurs, we throw an error.
                            if (error) {
                                db_insert.release();
                                res.status(404).send({
                                    status: false,
                                    error: error.sqlMessage
                                });
                                return;
                            }
                            db_insert.release();
                            res.status(200).send({
                                status: true,
                                message: 'Successfully Subscribed.'
                            });
                            sendEmail(email);
                        }
                    );
                });
            }
        });
    });
});

const sendEmail = email => {
    var mailOptions = {
        from: 'pz@parkingzone.co.uk',
        to: `${email}`,
        subject: 'Thank you for your subscription',
        html: get_subscription_email_html()
    };
    transporter.sendMail(mailOptions, function (error, info) {
        if (error) {
            console.log(error);
            return;
        } else {
            console.log('Subscribe Emila Send', email);
        }
    });
};
subscribeRoute.put('/:id', function (req, res, next) {
    res.status(405).send({
        status: 200,
        message: 'I subscribeRoute Update'
    });
});
subscribeRoute.delete('/:id', function (req, res, next) {
    res.status(405).send({
        status: 200,
        message: 'I subscribeRoute Delete'
    });
});

module.exports = subscribeRoute;
