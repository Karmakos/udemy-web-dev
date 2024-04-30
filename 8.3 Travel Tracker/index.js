import express from "express";
import bodyParser from "body-parser";
import pg from "pg";

const app = express();
const port = 3000;

const db = new pg.Client({
  user: "postgres",
  host: "localhost",
  database: "kenya",
  password: "2030",
  port: 5432,
});

db.connect();
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static("public"));



async function  visitedCountries() {
  
  const result = await db.query("SELECT * FROM visited_countries");

  let countryCodes = [];
  const countryRows = result.rows;
  countryRows.forEach((country) => {
  countryCodes.push(country.country_code);
});
return countryCodes;
}

app.get("/", async (req, res) => {
const countries = await visitedCountries();
  
res.render("index.ejs", {total: countries.length, countries: countries});

});

app.post("/add", async (req, res) =>
{
try {
const input = (req.body.country).toLowerCase();
console.log(input)
const resultSearch = await db.query("SELECT * FROM countries WHERE LOWER (country_name) LIKE '%' || $1 || '%'", [input]);

      try {
      if(resultSearch.rows !== 0) 
        {
        const selectedCountryCode = resultSearch.rows[0].country_code;
        await db.query("INSERT INTO visited_countries(country_code) VALUES($1)", [selectedCountryCode]);
        res.redirect("/");

        }
      } catch (error) {
        console.error(error);
        const countries = await visitedCountries();
        res.render("index.ejs", {total: countries.length, countries: countries, error: "The Country Already Exists, Try Again"});
      }


} catch (error) {
  console.error(error);
  const countries = await visitedCountries();
  
  res.render("index.ejs", {total: countries.length, countries: countries, error: "Please Enter a Valid Country, Try Again"});
}





});

app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
