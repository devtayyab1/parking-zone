var express = require('express');
var mailRoute = express.Router();

const transporter = require('../db/mail_service');
mailRoute.get('/', function (req, res, next) {
    var mailOptions = {
        from: 'pz@parkingzone.co.uk',
        to: 'aftabaminzoobiapps@gmail.com',
        subject: 'Parkingzone Confirmation Booking',
        html: `<p>Hi,</p>`
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
});

module.exports = mailRoute;

/**
 * 
 * Host: smtp.gmail.com
port: 465
Encryption: ssl
username: mailto:pz@parkingzone.co.uk
pw: pzgsuite123#
 */
