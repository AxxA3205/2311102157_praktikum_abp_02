const express = require('express');
const bodyParser = require('body-parser');
const methodOverride = require('method-override');
const path = require('path');

const app = express();
const PORT = 3000;

// View engine
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(methodOverride('_method'));
app.use(express.static(path.join(__dirname, 'public')));

// Routes
const questionsRouter = require('./routes/questions');
const participantsRouter = require('./routes/participants');
const scoresRouter = require('./routes/scores');
const playRouter = require('./routes/play');

app.use('/questions', questionsRouter);
app.use('/participants', participantsRouter);
app.use('/scores', scoresRouter);
app.use('/play', playRouter);

// Home
app.get('/', async (req, res) => {
  const db = require('./config/db');
  try {
    const [[{ total_questions }]] = await db.query('SELECT COUNT(*) as total_questions FROM questions');
    const [[{ total_participants }]] = await db.query('SELECT COUNT(*) as total_participants FROM participants');
    const [[{ total_scores }]] = await db.query('SELECT COUNT(*) as total_scores FROM scores');
    res.render('index', { total_questions, total_participants, total_scores });
  } catch (err) {
    res.render('index', { total_questions: 0, total_participants: 0, total_scores: 0 });
  }
});

app.listen(PORT, () => {
  console.log(`🧩 The Riddler running at http://localhost:${PORT}`);
});
