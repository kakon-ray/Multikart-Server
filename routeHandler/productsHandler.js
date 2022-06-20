const express = require("express");
const router = express.Router();
const { MongoClient, ServerApiVersion, ObjectId } = require("mongodb");
var ObjectID = require("mongodb").ObjectID;

const mongoAtlasUri =
  "mongodb://multicart_admin:UW9vTVSduGgNs0mt@cluster0-shard-00-00.fvzaz.mongodb.net:27017,cluster0-shard-00-01.fvzaz.mongodb.net:27017,cluster0-shard-00-02.fvzaz.mongodb.net:27017/?ssl=true&replicaSet=atlas-es8feq-shard-0&authSource=admin&retryWrites=true&w=majority";
const client = new MongoClient(mongoAtlasUri);
const collection = client.db("multicart").collection("products");
router.get("/", async (req, res) => {
  const cursor = collection.find({});
  const allValues = await cursor.toArray();
  const homepageValue = allValues.slice(0, 8);
  res.send(homepageValue);
});

module.exports = router;
