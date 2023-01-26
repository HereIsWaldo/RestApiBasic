const { ObjectId } = require("mongodb");

const { Database } = require("../database/index");

const COLLECTION = "products";

const { ProductsUtils } = require("./utils");

const debug = require("debug")("app:module services");

const getAll = async () => {
  const collection = await Database(COLLECTION);
  return await collection.find({}).toArray();
};

const getById = async (id) => {
  const collection = await Database(COLLECTION);
  return collection.findOne({ _id: ObjectId(id) });
};

const create = async (product) => {
  const collection = await Database(COLLECTION);
  let result = await collection.insertOne(product);

  return result.insertedId;
};

const deleteProduct = async (id) => {
  const collection = await Database(COLLECTION);
  const query = { _id: ObjectId(id) };
  const result = await collection.deleteOne(query);

  if (result.deletedCount === 1) {
    return id;
  } else {
    return 0;
  }
};

const updateProduct = async (id, productUpdate) => {
  const collection = await Database(COLLECTION);
  const filter = { _id: ObjectId(id) };
  const options = { upsert: false };
  const update = {
    $set: {
      ...productUpdate,
    },
  };
  const result = await collection.updateOne(filter, update, options);

  return await getById(id);
};

const generateReport = async (name, res) => {
  const products = await getAll();
  ProductsUtils.excelGenerator(products, name, res);
};

module.exports.ProductsService = {
  getAll,
  getById,
  create,
  generateReport,
  deleteProduct,
  updateProduct,
};
