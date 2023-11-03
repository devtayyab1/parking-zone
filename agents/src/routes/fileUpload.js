const express = require('express');
const multer = require('multer');
const path = require('path');
const router = express.Router();

// Image Upload
const imageStorage = multer.diskStorage({
    destination: 'public/images', // Destination to store image
    filename: (req, file, cb) => {
        cb(
            null,
            file.fieldname + '_' + Date.now() + path.extname(file.originalname)
        );
        // file.fieldname is name of the field (image), path.extname get the uploaded file extension
    }
});

const imageUpload = multer({
    storage: imageStorage,
    limits: {
        fileSize: 1000000 // 1000000 Bytes = 1 MB
    },
    fileFilter(req, file, cb) {
        if (!file.originalname.match(/\.(png|jpg)$/)) {
            // upload only png and jpg format
            return cb(new Error('only png & jpg format are supported'));
        }
        cb(undefined, true);
    }
});

router.post(
    '/',
    imageUpload.single('image'),
    (req, res) => {
        res.send({ status: true, file: req.file });
    },
    (error, req, res, next) => {
        res.status(400).send({
            status: false,
            error:
                error.message == 'File too large'
                    ? 'Please upload a file upto 1 MB'
                    : error.message
        });
    }
);

module.exports = router;
