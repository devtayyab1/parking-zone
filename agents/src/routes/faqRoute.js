var express = require('express');
var faqRoute = express.Router();
const db = require('../db/connection.js');
faqRoute.get('/', function (req, res, next) {
    var sql = "SELECT * FROM `faqs` WHERE status = 'Yes' AND removed = 'No'";
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
                data: groupByKey(results, 'type')
            });
        });
    });
});

faqRoute.get('/:id', function (req, res, next) {
    var id = req.params.id;
    var sql = `SELECT * FROM faqs WHERE status = 'Yes' AND removed = 'No' AND id = ${id} `;
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

faqRoute.post('/', function (req, res, next) {
    res.status(405).send({
        status: 200,
        message: 'I Faq POST'
    });
});
faqRoute.put('/:id', function (req, res, next) {
    res.status(405).send({
        status: 200,
        message: 'I FAQ Update'
    });
});
faqRoute.delete('/:id', function (req, res, next) {
    res.status(405).send({
        status: 200,
        message: 'I FAQ Deelte'
    });
});

function groupByKey(array, key) {
    return array_converstion(
        array.reduce((hash, obj) => {
            if (obj[key] === undefined) return hash;
            return Object.assign(hash, {
                [obj[key]]: (hash[obj[key]] || []).concat(obj)
            });
        }, {})
    );
}

const array_converstion = data => {
    let temparry = [];
    Object.keys(data).forEach(function (key, index) {
        temparry.push({ title: key, data: data[key] });
    });
    return temparry;
};

module.exports = faqRoute;
