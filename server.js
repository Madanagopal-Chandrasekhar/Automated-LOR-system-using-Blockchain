const express = require("express");
const path = require("path");
const mysql = require('mysql');

const app = express();


app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname + "/index.html"));
})

app.get("/indexfinal", (req, res) => {
    res.sendFile(path.join(__dirname + "/indexfinal.html"));
})

const server = app.listen(5000);
const portNumber = server.address().port;
console.log("server: " + portNumber);

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: "blockchain"
});

connection.connect(error => {
    if (error) {
        console.log("A error has been occurred "
            + "while connecting to database.");
        throw error;
    }

    //If Everything goes correct, Then start Express Server
    app.listen(3000, () => {
        console.log("Database connection is Ready and "
            + "Server is Listening on Port ", 3000);
    })
});