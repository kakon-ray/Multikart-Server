const express = require("express");
var bodyParser = require("body-parser");
const app = express();
require("dotenv").config();
var cors = require("cors");
const port = process.env.PORT || 5000;
const { MongoClient, ServerApiVersion, ObjectId } = require("mongodb");
var ObjectID = require("mongodb").ObjectID;

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
    const collection = client.db("multicart").collection("products");
    const cartCollection = client.db("multicart").collection("cartlist");
    const wishlistCollection = client.db("multicart").collection("wishlist");
    const comparelistCollection = client
      .db("multicart")
      .collection("comparelist");
    const checkoutCollection = client.db("multicart").collection("checkout");
    await client.connect();

    app.get("/products", async (req, res) => {
      const cursor = collection.find({});
      const allValues = await cursor.toArray();
      const homepageValue = allValues.slice(0, 8);
      res.send(homepageValue);
    });
    // start cartlist collection
    app.get("/cartlist", async (req, res) => {
      const email = req.query.email;
      const cursor = cartCollection.find({ email: email });
      const allValues = await cursor.toArray();
      res.send(allValues);
    });
    app.post("/cartlist", async (req, res) => {
      const data = req.body;
      const result = await cartCollection.insertOne(data);
      res.send(result);
    });
    app.delete("/cartlist", async (req, res) => {
      const id = req.query.id;
      const query = { _id: new ObjectID(id) };
      const result = await cartCollection.deleteOne(query);
      res.send(result);
    });

    // start wishlist collection
    app.get("/wishlist", async (req, res) => {
      const email = req.query.email;
      const cursor = wishlistCollection.find({ email: email });
      const allValues = await cursor.toArray();
      res.send(allValues);
    });

    app.post("/wishlist", async (req, res) => {
      const data = req.body;
      const result = await wishlistCollection.insertOne(data);
      res.send(result);
    });

    app.delete("/wishlist/:id", async (req, res) => {
      const id = req.params.id;
      const query = { _id: new ObjectID(id) };
      const deleteResult = await wishlistCollection.deleteOne(query);
      res.send(deleteResult);
    });
    // start comparelist collection
    app.get("/comparelist", async (req, res) => {
      const email = req.query.email;
      const cursor = comparelistCollection.find({ email: email });
      const allValues = await cursor.toArray();
      res.send(allValues);
    });
    app.post("/comparelist", async (req, res) => {
      const data = req.body;
      const result = await comparelistCollection.insertOne(data);
      res.send(result);
    });

    app.delete("/comparelist/:id", async (req, res) => {
      const id = req.params.id;
      const query = { _id: new ObjectID(id) };
      const deleteResult = await comparelistCollection.deleteOne(query);
      res.send(deleteResult);
    });

    // checkout collection start
    app.get("/checkout", async (req, res) => {
      const cursor = checkoutCollection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });

    app.post("/checkout", async (req, res) => {
      const result = await checkoutCollection.insertOne(data);
      res.send(result);
    });

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
