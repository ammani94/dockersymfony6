const express = require('express');
const mongoose = require('mongoose');
const app = express();


// Connexion base de données

// mongoose.connect('mongodb+srv://calKestis:calKestis2019@cluster0.ooxbd.mongodb.net/myFirstDatabase?retryWrites=true&w=majority',
//   { useNewUrlParser: true,
//     useUnifiedTopology: true })
//   .then(() => console.log('Connexion à MongoDB réussie !'))
//   .catch(() => console.log('Connexion à MongoDB échouée !'));

const bodyParser = require('body-parser');

app.use(bodyParser.json());

app.use((req, res, next) => {
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content, Accept, Content-Type, Authorization');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    next();
  });

  app.get('/', (request, response) => {
    response.status(200).json({
      message: 'Hello Docker!',
    });
  });
