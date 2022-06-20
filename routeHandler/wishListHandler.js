const express = require("express");
const router = express.Router();
const { MongoClient, ServerApiVersion, ObjectId } = require("mongodb");
var ObjectID = require("mongodb").ObjectID;

const mongoAtlasUri =
  "mongodb://multicart_admin:UW9vTVSduGgNs0mt@cluster0-shard-00-00.fvzaz.mongodb.net:27017,cluster0-shard-00-01.fvzaz.mongodb.net:27017,cluster0-shard-00-02.fvzaz.mongodb.net:27017/?ssl=true&replicaSet=atlas-es8feq-shard-0&authSource=admin&retryWrites=true&w=majority";
const client = new MongoClient(mongoAtlasUri);
const wishlistCollection = client.db("multicart").collection("wishlist");

// start wishlist collection
router.get("/", async (req, res) => {
  const email = req.query.email;
  const cursor = wishlistCollection.find({ email: email });
  const allValues = await cursor.toArray();
  res.send(allValues);
});

router.post("/", async (req, res) => {
  const data = req.body;
  const result = await wishlistCollection.insertOne(data);
  res.send(result);
});

router.delete("/:id", async (req, res) => {
  const id = req.params.id;
  const query = { _id: new ObjectID(id) };
  const deleteResult = await wishlistCollection.deleteOne(query);
  res.send(deleteResult);
});

module.exports = router;
