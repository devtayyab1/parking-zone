var express = require('express');
const db = require('../db/connection.js');
var Secret_Key =
    'sk_test_51LlZ1WIZ39EgqF7OgJp7z0uiBF08LryZIK6P9SpMfG5HDIMAbavA3DmKX9hZcr9RhHt9WzKKy3GoFaBRxi8RHXvc00FhZ6glJG';
const stripe = require('stripe')(Secret_Key);
var paymentRouter = express.Router();
paymentRouter.post('/createIntent', async (req, res, next) => {
    const amount = req.body.amount;
    const currency = req.body.currency;

    const airport_id = req.body.airport_id;

    var charged;
    try {
        charged = await stripe.paymentIntents.create({
            amount: parseInt(amount * 100),
            currency: currency
        });
        var sql = `SELECT * FROM airports_terminals where aid = ${airport_id}`;
        db.getConnection(function (err, db_query) {
            if (err) {
                db_query?.release();
                res.status(404).send({ status: false, error: err.message });
                return;
            }
            // Executing the MySQL query (select all data from the 'users' table).
            db_query.query(sql, function (err, results, fields) {
                // If some error occurs, we throw an error.
                if (err) {
                    console.log(err);
                    db_query?.release();
                    res.status(404).send({
                        status: false,
                        error: err.sqlMessage
                    });
                    return;
                }
                db_query?.release();
                res.status(200).send({
                    status: true,
                    airport_terminals: results,
                    client_secret: charged.client_secret,
                    id: charged.id
                });
            });
        });
    } catch (err) {
        return res.status(500).send({ status: false, message: err });
    }
});

paymentRouter.post('/confrimPayment', async (req, res, next) => {
    // const payment_intent = req.body.paymentIntent;
    // try {
    //     const paymentConfirm = await stripe.paymentIntents.confirm(
    //         payment_intent,
    //         {
    //             payment_method: 'pm_card_visa'
    //         }
    //     );
    //     res.status(200).send({ status: true, data: paymentConfirm });
    // } catch (err) {
    //     res.status(500).send({ status: false, message: err });
    // }
    res.status(404).send({
        status: false,
        message: 'this method is not allowed without the authtication'
    });
});

paymentRouter.post('/webhook', async (req, res, next) => {
    res.send({
        status: 'true',
        message: 'I am webhook'
    });
});
module.exports = paymentRouter;
