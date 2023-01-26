const { MongoClient } = require("mongodb");
const debug = require("debug")("app:module-database");

const { Config } = require("../config/index");

var connection = null;
module.exports.Database = (collection) => new Promise(async (res, rej) => {
    try {
      if (!connection) {
        const client = new MongoClient(Config.mongoUri);
        connection = await client.connect();
        debug("Nueva conexion realizada con Mongo");
      }
      debug("Conexion hecha con anterioridad... reutilizando conexion");
      const db = connection.db(Config.mongoDBName);
      res(db.collection(collection));
    } catch (error) {
      rej(error);
    }
  });
