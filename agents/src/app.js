const express = require('express');
const indexRouter = require('./routes/index');
const airportRouter = require('./routes/airportRoute');
const companyRouter = require('./routes/companyRoute');
const searchRoute = require('./routes/searchRoute');
const faqRoute = require('./routes/faqRoute');
const pagesRoute = require('./routes/pagesRoute');
const ticketRoute = require('./routes/ticketRoutes');
const paymentRoute = require('./routes/paymentRoute');
const bookingRoute = require('./routes/bookingRoute');
const fileUpload = require('./routes/fileUpload');
const subscribeRoute = require('./routes/subscribeRoute');
const mailRoute = require('./routes/mailRoute');
const LoungesBookingRoute = require('./routes/LoungesBookingRoute');
const HotelBookingRoute = require('./routes/HotelBookingRoute');
const TransferBookingRoute = require('./routes/TransferBookingRoute');
const path = require('path');
const logger = require('morgan');
const app = express();
app.use(logger('dev'));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

const port = 3000;
app.use(express.json());
app.use(
    express.urlencoded({
        extended: true
    })
);

app.use(express.static(path.join(__dirname, 'public/images')));

app.use('/public/images', express.static(__dirname + '/public/images'));
app.use('/', indexRouter);
app.use('/airports', airportRouter);
app.use('/companies', companyRouter);
app.use('/search', searchRoute);
app.use('/faq', faqRoute);
app.use('/pages', pagesRoute);
app.use('/tickets', ticketRoute);
app.use('/bookings', bookingRoute);
app.use('/lounges_bookings', LoungesBookingRoute);
app.use('/transfer_bookings', TransferBookingRoute);

app.use('/hotel_bookings', HotelBookingRoute);

app.use('/fileUpload', fileUpload);
app.use('/payments', paymentRoute);
app.use('/subscribeRoute', subscribeRoute);
app.use('/mailsending', mailRoute);

app.listen(port, () => {
    console.log(`Example App listening at http://localhost:${port}`);
});
