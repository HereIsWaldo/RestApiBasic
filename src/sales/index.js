const express = require('express');

const router = express.Router()


module.exports.SalesApi = (app) => {



    app.use("/api/sales/", router)
}