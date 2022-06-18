const express = require("express");
var bodyParser = require("body-parser");
const app = express();
require("dotenv").config();
var cors = require("cors");
const port = process.env.PORT || 5000;
const { MongoClient, ServerApiVersion } = require("mongodb");

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

const uri =
  "mongodb+srv://multicart_admin:UW9vTVSduGgNs0mt@cluster0.fvzaz.mongodb.net/?retryWrites=true&w=majority";
const client = new MongoClient(uri, {
  useNewUrlParser: true,
  useUnifiedTopology: true,
  serverApi: ServerApiVersion.v1,
});

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
      res.send(allValues);
    });
    // start cartlist collection
    app.get("/cartlist", async (req, res) => {
      const cursor = cartCollection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });
    app.post("/cartlist", async (req, res) => {
      const data = req.body;
      const name = data.name;
      const supplierName = data.supplierName;
      const price = data.price;
      const quantity = data.quantity;
      const text = data.text;
      const img = data.img;
      const img2 = data.img2;

      const result = await cartCollection.insertOne({
        name,
        supplierName,
        price,
        quantity,
        text,
        img,
        img2,
      });
      res.send(result);
    });

    // start wishlist collection
    app.get("/wishlist", async (req, res) => {
      const cursor = wishlistCollection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });

    app.post("/wishlist", async (req, res) => {
      const data = req.body;
      const name = data.name;
      const supplierName = data.supplierName;
      const price = data.price;
      const quantity = data.quantity;
      const text = data.text;
      const img = data.img;
      const img2 = data.img2;

      const result = await wishlistCollection.insertOne({
        name,
        supplierName,
        price,
        quantity,
        text,
        img,
        img2,
      });
      res.send(result);
    });
    // start comparelist collection
    app.get("/comparelist", async (req, res) => {
      const cursor = comparelistCollection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });
    app.post("/comparelist", async (req, res) => {
      const data = req.body;
      const name = data.name;
      const supplierName = data.supplierName;
      const price = data.price;
      const quantity = data.quantity;
      const text = data.text;
      const img = data.img;
      const img2 = data.img2;

      const result = await comparelistCollection.insertOne({
        name,
        supplierName,
        price,
        quantity,
        text,
        img,
        img2,
      });
      res.send(result);
    });

    // checkout collection start
    app.get("/checkout", async (req, res) => {
      const cursor = checkoutCollection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });

    app.post("/checkout", async (req, res) => {
      const data = req.body;
      const name = data.name;
      const supplierName = data.supplierName;
      const price = data.price;
      const quantity = data.quantity;
      const text = data.text;
      const img = data.img;
      const img2 = data.img2;

      const result = await checkoutCollection.insertOne({
        name,
        supplierName,
        price,
        quantity,
        text,
        img,
        img2,
      });
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
