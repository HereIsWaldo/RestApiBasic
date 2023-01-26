const { ObjectId } = require("mongodb");

const { Database } = require("../database/index");

const COLLECTION = "users";

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

const deleteUser = async (id) => {
  const collection = await Database(COLLECTION);
  const query = { _id: ObjectId(id) };
  const result = await collection.deleteOne(query);

  if (result.deletedCount === 1) {
    return id;
  } else {
    return 0;
  }
};

const updateUser = async (id, userUpdate) => {
  const collection = await Database(COLLECTION);
  const filter = { _id: ObjectId(id) };
  const options = { upsert: false };
  const update = {
    $set: {
      ...userUpdate,
    },
  };
  const result = await collection.updateOne(filter, update, options);

  return await getById(id);
};



module.exports.UsersService = {
  getAll,
  getById,
  create,
  deleteUser,
  updateUser,
};
