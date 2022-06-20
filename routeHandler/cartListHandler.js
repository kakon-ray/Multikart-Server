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

router.post("/", async (req, res) => {
  const data = req.body;

  const id = data.id;
  const query = { id: id };
  const cursor = cartCollection.find(query);
  const allValues = await cursor.toArray();
  let result;
  if (allValues.length > 0) {
    return;
  } else {
    result = await cartCollection.insertOne(data);
    res.send(result);
  }
});

router.delete("/", async (req, res) => {
  const id = req.query.id;
  const query = { _id: new ObjectID(id) };
  const result = await cartCollection.deleteOne(query);
  res.send(result);
});

module.exports = router;
