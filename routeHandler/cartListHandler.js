const { query } = require("express");
const express = require("express");
const router = express.Router();
const { MongoClient, ServerApiVersion, ObjectId } = require("mongodb");
var ObjectID = require("mongodb").ObjectID;

const mongoAtlasUri =
  "mongodb://multicart_admin:UW9vTVSduGgNs0mt@cluster0-shard-00-00.fvzaz.mongodb.net:27017,cluster0-shard-00-01.fvzaz.mongodb.net:27017,cluster0-shard-00-02.fvzaz.mongodb.net:27017/?ssl=true&replicaSet=atlas-es8feq-shard-0&authSource=admin&retryWrites=true&w=majority";
const client = new MongoClient(mongoAtlasUri);
const cartCollection = client.db("multicart").collection("cartlist");

router.get("/", async (req, res) => {
  const email = req.query.email;
  const cursor = cartCollection.find({ email: email });
  const allValues = await cursor.toArray();
  res.send(allValues);
});

// Post cartlist
router.post("/", async (req, res) => {
  const data = req.body;
  let result = await cartCollection.insertOne(data);
  res.send(result);
});

// Update cartlist checkbox
router.patch("/", async (req, res) => {
  const value = req.query.id;
  const id = value[1];
  const checkBox = value[0];

  const query = { _id: new ObjectId(id) };
  const update = { $set: { check: checkBox } };
  const options = { upsert: true };
  const result = cartCollection.updateOne(query, update, options);
  res.send(result);
});
// Update cartlist  quantity
router.patch("/quantity", async (req, res) => {
  const value = req.body;

  const id = value.id;
  let quantity = parseInt(value.value);

  const findquery = { _id: new ObjectId(id) };
  const cursor = await cartCollection.find(findquery);
  let dbArray = await cursor.toArray();
  let totalPriceResult = Number(dbArray[0].price) * quantity;

  const query = { _id: new ObjectId(id) };
  const update = { $set: { quantity: quantity, totalPrice: totalPriceResult } };
  const options = { upsert: true };
  const result = await cartCollection.updateOne(query, update, options);
  res.send(result);
});

// Update cartlist checkbox
router.put("/", async (req, res) => {
  const value = req.query.id;
  const query = {};
  const update = { $set: { check: value } };
  const options = { upsert: true };
  const result = cartCollection.updateMany(query, update, options);
  res.send(result);
});

router.delete("/", async (req, res) => {
  const id = req.query.id;
  const query = { _id: new ObjectID(id) };
  const result = await cartCollection.deleteOne(query);
  res.send(result);
});

module.exports = router;
