var express = require('express');
var companyRoute = express.Router();
const db = require('../db/connection.js');

companyRoute.get('/', function (req, res, next) {
    var sql =
        "SELECT * FROM `companies` WHERE `is_active` = 'Yes' AND `removed` = 'No'";
    db.getConnection(function (err, db_query) {
        if (err) {
            db_query.release();
            res.status(404).send({ status: false, error: err.message });
            return;
        }
        // Executing the MySQL query (select all data from the 'users' table).
        db.query(sql, function (error, results, fields) {
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
companyRoute.get('/:id', function (req, res, next) {
    var id = req.params.id;
    var sql = `SELECT * FROM companies WHERE is_active = 'Yes' AND removed = 'No' AND id = ${id} `;
    db.getConnection(function (err, db_query) {
        if (err) {
            db_query.release();
            res.status(404).send({ status: false, error: err.message });
            return;
        }
        // Executing the MySQL query (select all data from the 'users' table).
        db.query(sql, function (error, results, fields) {
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
companyRoute.post('/', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies POST'
    });
});
companyRoute.put('/:id', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies Update'
    });
});
companyRoute.delete('/:id', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies Deelte'
    });
});

module.exports = companyRoute;
