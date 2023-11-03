const mysql = require('mysql');
const db = mysql.createPool({
    connectionLimit: 15000,
    host: 'localhost',
    user: 'root',
    database: 'parkingz_parkingzone',
    password: '',
    multipleStatements: true
});


module.exports = db;
// DB_HOST=localhost
// DB_PORT=3306
// DB_DATABASE=parkingz_parkingzone
// DB_USERNAME=parkingz_parking
// DB_PASSWORD=1Qi^6Y=OHrI)
