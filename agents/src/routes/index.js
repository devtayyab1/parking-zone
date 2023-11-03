var express = require('express');
var router = express.Router();
var db = require('../db/connection');
router.get('/', function (req, res, next) {
    const sql_query = `SELECT ab.airportID, ab.referenceNo,ab.deprTerminal,ab.returnTerminal,ab.returnFlight, CONCAT(ab.first_name, " ", ab.last_name) as customer_name,booking_transaction.total_amount, ab.email as customer_email, ab.phone_number as customer_phone, companies.name as company_name, CONCAT(companies.overview , " ", companies.arival, " ", companies.return_proc ) as company_guidelines, airports.name as airport_name, companies.parking_type, ab.returnDate,ab.departDate, ab.no_of_days, ab.registration, ab.make, ab.model, ab.color, ab.created_at as booking_date FROM airports_bookings ab LEFT JOIN booking_transaction ON ab.referenceNo = booking_transaction.referenceNo LEFT JOIN companies ON companies.id = ab.companyId LEFT JOIN airports on ab.airportID = airports.id WHERE ab.id = '518' LIMIT 1; SELECT * from airports_terminals WHERE aid = 1;`;
    db.getConnection(function (error, db_query) {
        if (error) {
            db_query.release();
            res.status(404).send({ status: false, error: error });
            return;
        }
        db_query.query(sql_query, function (error, results, fields) {
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
        });
    });
});
module.exports = router;
