import express from "express";
import axios from "axios";

const app = express();
const port = 3000;
const API_URL = "https://secrets-api.appbrewery.com/";

//TODO 1: Fill in your values for the 3 types of auth.
const yourUsername = "john@12";
const yourPassword = "2030";
const yourAPIKey = "8d9ac7b6-0a05-4b34-8078-d95068681afe";
const yourBearerToken = "f6ed070e-53dc-4ff9-afc4-f1e129dbba43";

app.get("/", (req, res) => {
  res.render("index.ejs", { content: "API Response." });
});

app.get("/noAuth", async (req, res) => {
  const response = await axios.get('https://secrets-api.appbrewery.com/random');
  const info = JSON.stringify(response.data);
  res.render("index.ejs", { content: info });
});

app.get("/basicAuth", async (req, res) => {
  const responseBA = await axios.get('https://secrets-api.appbrewery.com/all?page=2', {
            auth: {
            username: yourUsername,
            password: yourPassword
          }});
  const infoBA = JSON.stringify(responseBA.data); 
  res.render("index.ejs", { content: infoBA });
  });

app.get("/apiKey", async (req, res) => {
const responseAK = await axios.get('https://secrets-api.appbrewery.com/filter?score=5&apiKey=7969fe9d-528a-445f-b925-7da0bfaddb5f');
const infoAK = JSON.stringify(responseAK.data);
res.render("index.ejs", { content: infoAK });
});

app.get("/bearerToken", async (req, res) => {
const responseBT = await axios.get('https://secrets-api.appbrewery.com/secrets/42',
        {
          headers:{
            Authorization: `Bearer 664b7177-84b3-48db-b35d-5b2256ea2b43`
          },
        });
  const infoBT = JSON.stringify(responseBT.data);
  res.render("index.ejs", {content: infoBT});
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
