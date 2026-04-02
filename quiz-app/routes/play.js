const express = require('express');
const router = express.Router();
const db = require('../config/db');

// GET play page
router.get('/', async (req, res) => {
  try {
    const [participants] = await db.query('SELECT * FROM participants ORDER BY name ASC');
    res.render('play', { participants });
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// GET questions JSON for play (by difficulty)
router.get('/questions', async (req, res) => {
  try {
    const [easy] = await db.query("SELECT * FROM questions WHERE difficulty='easy' ORDER BY RAND() LIMIT 4");
    const [medium] = await db.query("SELECT * FROM questions WHERE difficulty='medium' ORDER BY RAND() LIMIT 4");
    const [hard] = await db.query("SELECT * FROM questions WHERE difficulty='hard' ORDER BY RAND() LIMIT 2");
    
    // Gabungkan: 4 easy + 4 medium + 2 hard = 10 soal
    const allQuestions = [...easy, ...medium, ...hard];
    
    // Hapus correct_answer dari response (security)
    const sanitized = allQuestions.map((q, index) => ({
      id: q.id,
      question_text: q.question_text,
      option_a: q.option_a,
      option_b: q.option_b,
      option_c: q.option_c,
      option_d: q.option_d,
      difficulty: q.difficulty,
      level: index + 1
    }));
    
    res.json({ questions: sanitized });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// POST check answer
router.post('/check', async (req, res) => {
  const { question_id, answer } = req.body;
  try {
    const [rows] = await db.query('SELECT correct_answer FROM questions WHERE id = ?', [question_id]);
    if (!rows.length) return res.json({ correct: false });
    res.json({ correct: rows[0].correct_answer === answer, correct_answer: rows[0].correct_answer });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
