const express = require("express");

const router = express.Router();
const { UsersController } = require("./controller");

module.exports.UsersAPI = (app) => {
  router
    .get("/", UsersController.getUsers)
    .get("/:id", UsersController.getUser)
    .post("/", UsersController.createUser)
    .delete("/delete/:id", UsersController.deleteUser)
    .post("/update/:id",UsersController.updateUser);

  app.use("/api/users", router);
};