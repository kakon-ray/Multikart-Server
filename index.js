const express = require("express");
const app = express();
require("dotenv").config();
const port = process.env.PORT || 5000;
const { MongoClient, ServerApiVersion } = require("mongodb");

app.get("/", (req, res) => {
  res.send("Hello World!");
});

app.listen(port, () => {
  console.log(`Example app listening on port ${port}`);
});

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
    const collection = client.db("multicart").collection("product");
    await client.connect();

    app.get("/hello", async (req, res) => {
      const cursor = collection.find({});
      const allValues = await cursor.toArray();
      res.send(allValues);
    });
  } catch {}
}

run();
