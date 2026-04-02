const express = require('express');
const router = express.Router();
const db = require('../config/db');

// GET all questions (JSON for DataTable)
router.get('/json', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM questions ORDER BY created_at DESC');
    res.json({ data: rows });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// GET questions page
router.get('/', async (req, res) => {
  res.render('questions');
});

// GET add form
router.get('/add', (req, res) => {
  res.render('question_form', { question: null, action: '/questions', method: 'POST' });
});

// POST create
router.post('/', async (req, res) => {
  const { question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level } = req.body;
  try {
    await db.query(
      'INSERT INTO questions (question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level) VALUES (?,?,?,?,?,?,?,?)',
      [question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level || 1]
    );
    res.redirect('/questions');
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// GET edit form
router.get('/:id/edit', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM questions WHERE id = ?', [req.params.id]);
    if (!rows.length) return res.redirect('/questions');
    res.render('question_form', { question: rows[0], action: `/questions/${req.params.id}?_method=PUT`, method: 'POST' });
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// PUT update
router.put('/:id', async (req, res) => {
  const { question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level } = req.body;
  try {
    await db.query(
      'UPDATE questions SET question_text=?, option_a=?, option_b=?, option_c=?, option_d=?, correct_answer=?, difficulty=?, prize_level=? WHERE id=?',
      [question_text, option_a, option_b, option_c, option_d, correct_answer, difficulty, prize_level || 1, req.params.id]
    );
    res.redirect('/questions');
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// DELETE
router.delete('/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM questions WHERE id = ?', [req.params.id]);
    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
