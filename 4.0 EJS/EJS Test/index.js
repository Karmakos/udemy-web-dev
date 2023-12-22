import express from "express";

const app = express ();
const port = 3000;
app.get("/", function(req, res)
{
    const today = new Date();

    const day = today.getDay();

    let type = "a Weekday";
    let adv = "Time to Work Hard";

    if (day === 0 || day === 6)
    {
        type = "the Weekend";
        adv = "Time to Rest";
    }



    res.render("index.ejs",
    {
        typeOfDay: type,
        adviseDo: adv,

    });
});




app.listen (port, function()
{
    console.log(`Server running at port ${port}.`)
});