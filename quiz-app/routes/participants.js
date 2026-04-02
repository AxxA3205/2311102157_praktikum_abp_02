const express = require('express');
const router = express.Router();
const db = require('../config/db');

// GET JSON for DataTable
router.get('/json', async (req, res) => {
  try {
    const [rows] = await db.query(`
      SELECT p.*, 
        COUNT(s.id) as total_games,
        COALESCE(MAX(s.score), 0) as best_score
      FROM participants p
      LEFT JOIN scores s ON p.id = s.participant_id
      GROUP BY p.id
      ORDER BY p.created_at DESC
    `);
    res.json({ data: rows });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// GET participants page
router.get('/', (req, res) => {
  res.render('participants');
});

// GET add form
router.get('/add', (req, res) => {
  res.render('participant_form', { participant: null, action: '/participants', method: 'POST' });
});

// POST create
router.post('/', async (req, res) => {
  const { name, email } = req.body;
  try {
    await db.query('INSERT INTO participants (name, email) VALUES (?,?)', [name, email]);
    res.redirect('/participants');
  } catch (err) {
    if (err.code === 'ER_DUP_ENTRY') {
      res.render('participant_form', { 
        participant: { name, email }, 
        action: '/participants', 
        method: 'POST',
        error: 'Email sudah terdaftar!'
      });
    } else {
      res.status(500).send(err.message);
    }
  }
});

// GET edit form
router.get('/:id/edit', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT * FROM participants WHERE id = ?', [req.params.id]);
    if (!rows.length) return res.redirect('/participants');
    res.render('participant_form', { 
      participant: rows[0], 
      action: `/participants/${req.params.id}?_method=PUT`, 
      method: 'POST' 
    });
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// PUT update
router.put('/:id', async (req, res) => {
  const { name, email } = req.body;
  try {
    await db.query('UPDATE participants SET name=?, email=? WHERE id=?', [name, email, req.params.id]);
    res.redirect('/participants');
  } catch (err) {
    res.status(500).send(err.message);
  }
});

// DELETE
router.delete('/:id', async (req, res) => {
  try {
    await db.query('DELETE FROM participants WHERE id = ?', [req.params.id]);
    res.json({ success: true });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

module.exports = router;
