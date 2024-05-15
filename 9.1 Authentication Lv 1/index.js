import express from "express";
import bodyParser from "body-parser";
import pg from "pg";

const app = express();
const port = 3000;

const db = new pg.Client({
  user: "postgres",
  host: "localhost",
  database: "secrets",
  password: "2030",
  port: 5432,
});

app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static("public"));
db.connect()

app.get("/", (req, res) => {
  res.render("home.ejs");
});

app.get("/login", (req, res) => {
  res.render("login.ejs");
});

app.get("/register", (req, res) => {
  res.render("register.ejs");
});

app.post("/register", async (req, res) => {
  const email = req.body.username;
  const password = req.body.password;
  try {
    const checkUser = await db.query("SELECT * FROM users WHERE user_email = $1", [email]);

if (checkUser.rows.length > 0) {
  res.send("Email Already Registered Please Login");
  
} else {
   await db.query("INSERT INTO users (user_email, user_password) VALUES($1, $2);", [email, password]);

  res.render("secrets.ejs"); 
}
  } catch (error) {
    console.log(error)
  }
});

app.post("/login", async (req, res) => {
const email = req.body.username;
const password = req.body.password;
try {
  const result = await db.query("SELECT * FROM users WHERE user_email = $1;", [email]);
if (result.rows.length > 0 ) {
  const user = result.rows[0];
  const userPassword = user.user_password;
  if (userPassword === password) {
    res.render("secrets.ejs")
  } else {
    res.send("You've Entered the Wrong Password")
  }
    
} else {
res.send("The Email You've Entered Doesn't Exist; Register")
  
}
} catch (error) {
  console.log(error);
}




});

app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
