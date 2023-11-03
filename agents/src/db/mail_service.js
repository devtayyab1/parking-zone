var nodemailer = require('nodemailer');
var transporter = nodemailer.createTransport({
    host: 'smtp.gmail.com',
    port: 465,
    from: 'pz@parkingzone.co.uk',
    secure: true, // true for 465, false for other ports
    Encryption: 'ssl',
    auth: {
        user: 'pz@parkingzone.co.uk',
        pass: 'pzgsuite123#'
    }
});

module.exports = transporter;
