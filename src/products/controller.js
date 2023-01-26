const { ProductsService } = require("./services");
const debug = require("debug")("app:module-products-controller");
const { Response } = require("../common/response");
const createError = require("http-errors");
const { response } = require("express");

module.exports.ProductsController = {
  getProducts: async (req, res) => {
    try {
      let products = await ProductsService.getAll();
      Response.success(res, 200, "Lista de productos", products);
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },
  getProduct: async (req, res) => {
    try {
      const {
        params: { id },
      } = req;
      let product = await ProductsService.getById(id);
      if (!product) {
        Response.error(res, createError.NotFound());
      } else {
        Response.success(res, 200, `Producto ${id}`, product);
      }
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },
  createProduct: async (req, res) => {
    try {
      const { body } = req;
      if (!body || Object.keys(body).length === 0) {
        Response.error(res, new createError.BadRequest());
      } else {
        const insertedId = await ProductsService.create(body);
        Response.success(res, 201, "Producto agregado", insertedId);
      }
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },

  deleteProduct: async (req, res) => {
    try {
      const {
        params: { id },
      } = req;
      let deleted = await ProductsService.deleteProduct(id);
      if (deleted === 0) {
        Response.error(res, new createError.NotFound());
      } else {
        Response.success(res, 201, "Producto Eliminado", deleted);
      }
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },

  updateProduct: async (req, res) => {
    try {
      const {
        params: { id },
      } = req;
      const { body } = req;
      let updated = await ProductsService.updateProduct(id, body);
      Response.success(res, 201, "Producto Actualizado", updated);
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },

  generateReport: (req, res) => {
    try {
      ProductsService.generateReport("inventario", res);
    } catch (error) {
      debug(error);
      Response.error(res);
    }
  },
};
