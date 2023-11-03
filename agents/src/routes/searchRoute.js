var express = require('express');
var moment = require('moment');
const db = require('../db/connection.js');
var request = require('request');

var searchRouter = express.Router();
searchRouter.get('/', function (req, res, next) {
    /*
     *getting all query parameters
     */
    var pickup_date = req.query.pickup_date;
    var pickup_time = req.query.pickup_time;

    var departure_date = req.query.departure_date;
    var departure_time = req.query.departure_time;
    var airport_id = req.query.airport_id;
    var no_of_days = req.query?.no_of_days;
    var bookingfor = req.query?.bookingfor;
    var promo = req.query?.promo;
    var promo2 = req.query?.promo2;
    var filter1 = req.query?.filter1;
    var filter2 = req.query?.filter2;
    var filter3 = req.query?.filter3;

    /*
     * Ended All query parameters
     */

    var search_filter = '';
    var search_filter3 = '';
    var search_filter2 = 'order by sort_by asc';

    //  search filters
    if (filter1 != '' && filter1 != 'All') {
        search_filter = `and parking_type = ${filter1}`;
    }
    if (filter2 == 'low-to-high') {
        search_filter2 =
            'order by featured asc, recommended asc,parking_type asc, price asc';
    } else if (filter2 == 'high-to-low') {
        search_filter2 = 'order by price desc';
    } else if (filter2 == 'distance') {
        search_filter2 = 'order by travel_time asc';
    }
    if (filter3 != '') {
        search_filter3 = `and terminal = ${filter3}`;
    }

    var total_days = parseInt(no_of_days + 1);
    if (total_days > 30) {
        total_days = 30;
    } else if (total_days <= 0) {
        total_days = 0;
    }
    var year = moment(departure_date).format('YYYY');
    var month = moment(departure_date).format('M');
    //  var day = moment(departure_date).format("D");

    // code to get companies from our database
    var sql = `SELECT  distinct fapp.id,fc.company_code as product_code, fc.opening_time,fc.closing_time,fc.id as companyID,fc.aph_id,fc.name,fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview, IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.extra_charges,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport, fc.cancelable, fc.editable, fc.bookingspace, fasb.brand_name, fapb.after_30_days, fapp.id as pl_id, IF( fapb.day_${total_days} >0, fapb.day_${total_days}+fapp.extra, 0.00) AS price, JSON_ARRAY(GROUP_CONCAT(fa.description)) facilities FROM companies as fc INNER JOIN facilities fa  ON fc.id = fa.company_id left join companies_set_price_plans as fapp on fc.id = fapp.cid left join companies_set_assign_price_plans  as fasb on fapp.id = fasb.plan_id and fasb.day_no = 'day_${total_days}' left join companies_product_prices as fapb on fapb.cid = fc.id and fapb.brand_name = fasb.brand_name WHERE is_active = 'Yes' and removed != 'Yes'  and airport_id = ${airport_id} and aph_id is null and fapp.cmp_month = ${month}  and fapp.cmp_year = ${year} GROUP BY fa.company_id ${search_filter} ${search_filter2} ${search_filter3}`;
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
            AirPortDetails(airport_id)
                .then(airport_details => {
                    GlobalBooking(
                        airport_details[0].iata_code,
                        departure_date,
                        departure_time,
                        pickup_date,
                        pickup_time
                    )
                        .then(data => {
                            get_records_global(
                                airport_id,
                                data.map(item => `'${item.sku}'`),
                                search_filter,
                                data.map(item => {
                                    return {
                                        price: `${item.price}`,
                                        sku: `${item.sku}`,
                                        featured: `${item.features}`
                                    };
                                })
                            )
                                .then(global_recored => {
                                    APH_Request(
                                        airport_id,
                                        moment(departure_date).format(
                                            'DD-MM-YYYY'
                                        ),
                                        moment(pickup_date).format(
                                            'DD-MM-YYYY'
                                        ),
                                        departure_time,
                                        pickup_time,
                                        no_of_days
                                    )
                                        .then(data => {
                                            let all_data = JSON.parse(data);
                                            db_query.release();
                                            res.status(200).send({
                                                status: true,
                                                data: [
                                                    //...global_recored,
                                                    //...results,
                                                    ...all_data.all_records
                                                ]
                                            });
                                        })
                                        .catch(err => {
                                            db_query.release();
                                            res.status(404).send({
                                                ev_msg: 'aph_erro_messsage Function Catch',
                                                status: false,
                                                error: err
                                            });
                                        });
                                })
                                .catch(err => {
                                    db_query.release();
                                    res.status(404).send({
                                        dev_msg:
                                            'get_records_global Function Catch',
                                        status: false,
                                        error: err
                                    });
                                });
                        })
                        .catch(err => {
                            db_query.release();
                            res.status(404).send({
                                dev_msg: 'GlobalBooking Function Catch',
                                status: false,
                                error: 'There is some unknown Error'
                            });
                        });
                })
                .catch(err => {
                    /// AirPortDetails Function Catch
                    db_query.release();
                    res.status(404).send({
                        dev_msg: 'AirPortDetails Function Catch',
                        status: false,
                        error: err
                    });
                });
        });
    });
});

function APH_Request(
    airport_id,
    departure_date,
    pickup_date,
    pickup_time,
    departure_time,
    no_of_days
) {
    return new Promise((resolve, reject) => {
        var options = {
            method: 'POST',
            url: 'https://www.parkingzone.co.uk/api/api_booking_functions.php',
            headers: {},
            formData: {
                airport: airport_id,
                dropdate: pickup_date,
                pickdate: departure_date,
                dropoftime: departure_time,
                pickuptime: pickup_time,
                no_of_days: no_of_days,
                promo: '',
                filter1: '',
                filter2: '',
                filter3: '',
                bookingfor: 'airport_parking',
                action: 'getCompaniesForMobile'
            }
        };
        request(options, function (error, response, body) {
            if (!error && response.statusCode == 200) {
                resolve(body);
            } else {
                reject(response);
            }
        });
    });
}
function get_records_global(
    airport_id,
    company_code,
    search_filter,
    globalitem
) {
    return new Promise((resolve, reject) => {
        if (
            company_code != null &&
            company_code != undefined &&
            company_code.length != 0 &&
            airport_id != null &&
            airport_id != undefined
        ) {
            company_code = `and fc.company_code IN (${company_code})`;
            var sql = `select fc.company_code as sku, 'global' as park_api,fc.id as id, fc.opening_time, fc.closing_time,fc.id as companyID,fc.aph_id,fc.name, fc.processtime,fc.awards,fc.featured,fc.recommended,fc.special_features,fc.overview, IF( LENGTH(fc.returnfront) >0,fc.returnfront,fc.return_proc) AS return_proc,IF( LENGTH(fc.arivalfront) >0,fc.arivalfront,fc.arival) AS arival,fc.terms,fc.address,fc.town,fc.post_code,fc.message,fc.parking_type,fc.logo,fc.travel_time,fc.miles_from_airport,fc.cancelable,fc.editable,fc.bookingspace, JSON_ARRAY(GROUP_CONCAT(fa.description)) facilities FROM companies as fc LEFT JOIN facilities as fa ON fc.id = fa.company_id  where is_active = 'Yes' and airport_id = ${airport_id} ${company_code} GROUP BY fa.company_id ${search_filter}`;

            db.getConnection(function (err, db_query) {
                if (err) {
                    db_query.release();
                    reject(err);
                }
                db.query(sql, function (error, results, fields) {
                    if (error) {
                        db_query.release();
                        reject(error);
                    }
                    db_query.release();
                    resolve(
                        results.map(itm => ({
                            ...globalitem.find(
                                item => item.sku === itm.sku && item
                            ),
                            ...itm
                        }))
                    );
                });
            });
        } else {
            resolve([]);
        }
    });
}

function GlobalBooking(airport_id, from_date, from_time, to_date, to_time) {
    return new Promise((resolve, reject) => {
        try {
            from_date = moment(from_date).format('DD-MM-YYYY');
            to_date = moment(to_date).format('DD-MM-YYYY'); //, strtotime(to_date));
            var url = 'https://globalparkingmanagement.co.uk/api/search';
            var getString = `?key=fsemmmp8kkt78eof&airport=${airport_id}&departure=${to_date} ${from_time}&arrival=${from_date} ${to_time}`;
            var final = `${url}${getString}`;

            RemoteRequest(final)
                .then(result => {
                    //    console.log(result, 'Resulttt');
                    resolve(result);
                })
                .catch(err => {
                    reject(err);
                });
        } catch (error) {
            reject(error);
        }
    });
}

function RemoteRequest(url) {
    return new Promise((resolve, reject) => {
        request(url, function (error, response, body) {
            // console.log(response.status);
            if (!error && response.statusCode == 200) {
                let rese = JSON.parse(body);
                if (rese.success) {
                    resolve(rese.data);
                } else {
                    resolve([]);
                }
            } else {
                let data = [];
                resolve(data);
            }
        });
    });
}

function AirPortDetails(airport_id) {
    return new Promise((resolve, reject) => {
        var sql = `SELECT id,iata_code, name FROM airports WHERE status = 'Yes' AND id=${airport_id}`;
        db.getConnection(function (err, db_query) {
            if (err) {
                db_query.release();
                reject(err.message);
                return;
            }
            db_query.query(sql, function (error, results, fields) {
                if (error) {
                    db_query.release();
                    reject(error.message);
                    return;
                }
                if (results.length > 0) {
                    db_query.release();
                    resolve(results);
                } else {
                    db_query.release();
                    reject('No Airports found');
                }
            });
        });
    });
}

searchRouter.get('/:id', function (req, res, next) {
    res.send({ test: 'this is me and you for testing purpose' });
});
module.exports = searchRouter;
