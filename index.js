const express = require("express");
const mongoose = require("mongoose");
var bodyParser = require("body-parser");
const app = express();
require("dotenv").config();
var cors = require("cors");
const port = process.env.PORT || 5000;
const { MongoClient, ServerApiVersion, ObjectId } = require("mongodb");
var ObjectID = require("mongodb").ObjectID;

const productsHandler = require("./routeHandler/productsHandler");
const cartListHandler = require("./routeHandler/cartListHandler");
const wishListHandler = require("./routeHandler/wishListHandler");
const compareListHandler = require("./routeHandler/compareListHandler");

app.get("/", (req, res) => {
  res.send("Hello World!");
});

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
});

app.use(cors());

app.use(bodyParser.urlencoded({ extended: false }));

// parse application/json
app.use(bodyParser.json());
// user: multicart_admin;
// pass: UW9vTVSduGgNs0mt;

var uri =
  "mongodb://multicart_admin:UW9vTVSduGgNs0mt@cluster0-shard-00-00.fvzaz.mongodb.net:27017,cluster0-shard-00-01.fvzaz.mongodb.net:27017,cluster0-shard-00-02.fvzaz.mongodb.net:27017/?ssl=true&replicaSet=atlas-es8feq-shard-0&authSource=admin&retryWrites=true&w=majority";

const client = new MongoClient(uri);

async function run() {
  try {
    const checkoutCollection = client.db("multicart").collection("checkout");
    await client.connect();

    app.use("/products", productsHandler);
    app.use("/cartlist", cartListHandler);
    app.use("/wishlist", wishListHandler);
    app.use("/comparelist", compareListHandler);

    // CORS Error solve
    app.use(function (req, res, next) {
      res.header("Access-Control-Allow-Origin", "*");
      res.header("Access-Control-Allow-Origin", "http://localhost:3000");
      res.header("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE");
      res.header("Access-Control-Allow-Headers", "application/json");
      res.header("Access-Control-Allow-Credentials", true);
      next();
    });
  } catch {}
}

run();
