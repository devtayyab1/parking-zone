var express = require('express');

var airportRouter = express.Router();
const db = require('../db/connection.js');
airportRouter.get('/', function (req, res, next) {
    var sql =
        "SELECT id, id as value, name as label, iata_code, name, profile_image,city, address FROM `airports` WHERE `status` = 'Yes'";
    db.getConnection(function (err, db_query) {
        if (err) {
            db_query.release();
            res.status(404).send({ status: false, error: err.message });
            return;
        }
        // Executing the MySQL query (select all data from the 'users' table).
        db_query.query(sql, function (error, results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_query.release();
                res.status(404).send({
                    status: false,
                    error: error.sqlMessage
                });
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

airportRouter.get('/:id', function (req, res, next) {
    let id = req.params.id;
    var sql = `SELECT * FROM airports WHERE status = 'Yes' AND id = ${id}`;
    db.getConnection(function (err, db_query) {
        if (err) {
            db_query.release();
            res.status(404).send({ status: false, error: err.message });
            return;
        }
        // Executing the MySQL query (select all data from the 'users' table).
        db_query.query(sql, function (error, results, fields) {
            // If some error occurs, we throw an error.
            if (error) {
                db_query.release();
                res.status(404).send({
                    status: false,
                    error: error.sqlMessage
                });
            }
            db_query.release();
            res.status(200).send({
                status: true,
                data: results
            });
        });
    });
});

module.exports = airportRouter;
