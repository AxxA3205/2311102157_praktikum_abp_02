const express = require('express');
const router = express.Router();
const db = require('../config/db');

// GET leaderboard page
router.get('/', (req, res) => {
  res.render('leaderboard');
});

// GET leaderboard JSON
router.get('/json', async (req, res) => {
  try {
    const [rows] = await db.query(`
      SELECT s.id, p.name, p.email, s.score, s.correct_answers, s.total_questions,
        DATE_FORMAT(s.played_at, '%d/%m/%Y %H:%i') as played_at
      FROM scores s
      JOIN participants p ON s.participant_id = p.id
      ORDER BY s.score DESC, s.played_at DESC
    `);
    res.json({ data: rows });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// POST save score (dipanggil dari halaman play)
router.post('/save', async (req, res) => {
  const { participant_id, score, total_questions, correct_answers } = req.body;
  try {
    await db.query(
      'INSERT INTO scores (participant_id, score, total_questions, correct_answers) VALUES (?,?,?,?)',
      [participant_id, score, total_questions, correct_answers]
    );
    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// DELETE score
router.delete('/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM scores WHERE id = ?', [req.params.id]);
    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
