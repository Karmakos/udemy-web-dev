import express from "express";
import axios from "axios";

const app = express();
const port = 3000;

app.use(express.static('public'));

const response = await axios.get('https://secrets-api.appbrewery.com/random')
const responseSecret = JSON.stringify(response.data.secret);
const responseUser = JSON.stringify(response.data.username);
console.log(response.data)
// app.get("/", (req, res)=>
// {
//     res.render("index.ejs", {secret: responseSecret, user: responseUser});

// });

app.get("/", async (req, res)=>
{
    try{
    
    res.render("index.ejs", { secret: responseSecret, user: responseUser });
    }catch(error)
    {
        const err = JSON.stringify(error.response.data);
        res.render("index.ejs", { secret: responseSecret, user: responseUser });
    }
}
);


app.listen(port, 
    console.log("App running at port "+ port)
    );
