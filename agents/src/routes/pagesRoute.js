var express = require('express');
var pagesRoute = express.Router();
const db = require('../db/connection.js');
pagesRoute.get('/', function (req, res, next) {
    var type = req.query.type;
    var linkmatch = req.query.linkmatch;

    var sql = '';
    if (linkmatch == 'blogs') {
        sql = `SELECT * FROM pages WHERE type = 'post' AND removed = 'No' AND status='Yes' `;
    } else if (linkmatch == 'static_pages') {
        sql = `SELECT * FROM airports LEFT JOIN pages ON airports.id = pages.typeid WHERE pages.slug IN ( "gatwick-airport-parking", "heathrow-airport-parking", "stansted-airport-parking", "birmingham-airport-parking", "edinburgh-airport-parking", "southampton-airport-parking", "liverpool-airport-parking", "luton-airport-parking", "manchester-airport-parking", "bristol-airport-parking", "east-midlandsairport-parking", "glasgow-airport-parking" )`;
    } else if (linkmatch == 'type') {
        sql = `SELECT * FROM pages WHERE type = '${type}' AND \`show\` = '1' AND removed = 'No'`;
    } else if (linkmatch == 'slug') {
        sql = `SELECT * FROM pages WHERE slug = '${type}' AND \`show\` = '1' AND removed = 'No'`;
    } else if (linkmatch == 'page_title') {
        sql = `SELECT * FROM pages WHERE page_title = '${type}' AND \`show\` = '1' AND removed = 'No'`;
    }

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
                data: results,
                totoal_records: results.length
            });
        });
    });
});
pagesRoute.get('/:id', function (req, res, next) {
    var id = req.params.id;
    var sql = `SELECT * FROM companies WHERE is_active = 'Yes' AND removed = 'No' AND id = ${id}`;
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
pagesRoute.post('/', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies POST'
    });
});
pagesRoute.put('/:id', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies Update'
    });
});
pagesRoute.delete('/:id', function (req, res, next) {
    res.status(405).send({
        status: true,
        message: 'I companies Deelte'
    });
});

module.exports = pagesRoute;
