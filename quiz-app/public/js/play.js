// play.js - Who Wants To Be A Millionaire Quiz Logic

const PRIZE_LADDER = [
  { level: 10, val: '1.000.000', milestone: true },
  { level: 9,  val: '500.000',  milestone: false },
  { level: 8,  val: '250.000',  milestone: false },
  { level: 7,  val: '125.000',  milestone: false },
  { level: 6,  val: '64.000',   milestone: false },
  { level: 5,  val: '32.000',   milestone: true },
  { level: 4,  val: '16.000',   milestone: false },
  { level: 3,  val: '8.000',    milestone: false },
  { level: 2,  val: '4.000',    milestone: false },
  { level: 1,  val: '1.000',    milestone: false },
];

let state = {
  participantId: null,
  participantName: '',
  questions: [],
  currentIndex: 0,
  score: 0,
  correctAnswers: 0,
  lifelineUsed: false,
  answered: false
};

// ---- SCREEN HELPERS ----
function showScreen(id) {
  $('.play-screen').removeClass('active').hide();
  $('#' + id).addClass('active').show();
}

// ---- SCREEN 1: SELECT PARTICIPANT ----
$(document).ready(function () {
  showScreen('screen-select');
  buildPrizeLadder();

  // Select participant
  $(document).on('click', '.participant-btn', function () {
    $('.participant-btn').removeClass('selected');
    $(this).addClass('selected');
    state.participantId = $(this).data('id');
    state.participantName = $(this).data('name');
    $('#startQuizBtn').prop('disabled', false);
  });

  // Start quiz
  $('#startQuizBtn').on('click', function () {
    if (!state.participantId) return;
    loadQuestions();
  });

  // 50:50 Lifeline
  $('#lifeline5050').on('click', function () {
    if (state.lifelineUsed || state.answered) return;
    use5050();
  });

  // Play again
  $('#playAgainBtn').on('click', function () {
    resetState();
    showScreen('screen-select');
    $('.participant-btn').removeClass('selected');
    $('#startQuizBtn').prop('disabled', true);
  });
});

// ---- BUILD PRIZE LADDER ----
function buildPrizeLadder() {
  let html = '';
  PRIZE_LADDER.forEach(function (item) {
    var cls = 'prize-item' + (item.milestone ? ' prize-milestone' : '');
    html += `<div class="${cls}" id="prize-${item.level}">
      <span class="prize-num">${item.level}</span>
      <span class="prize-val">Rp ${item.val}</span>
    </div>`;
  });
  $('#prizeLadder').html(html);
}

function updatePrizeLadder(currentLevel) {
  PRIZE_LADDER.forEach(function (item) {
    var el = $('#prize-' + item.level);
    el.removeClass('current passed');
    if (item.level === currentLevel) {
      el.addClass('current');
    } else if (item.level < currentLevel) {
      el.addClass('passed');
    }
  });
}

// ---- LOAD QUESTIONS ----
function loadQuestions() {
  $.get('/play/questions', function (data) {
    if (!data.questions || data.questions.length === 0) {
      Swal.fire({
        title: 'Soal tidak cukup!',
        text: 'Tambahkan lebih banyak soal di bank soal terlebih dahulu.',
        icon: 'warning',
        background: '#1a1a35',
        color: '#fff'
      });
      return;
    }
    state.questions = data.questions;
    state.currentIndex = 0;
    state.score = 0;
    state.correctAnswers = 0;
    state.lifelineUsed = false;
    state.answered = false;

    $('#playerName').text(state.participantName);
    $('#totalQ').text(state.questions.length);
    $('#lifeline5050').prop('disabled', false).css('opacity', 1);

    showScreen('screen-quiz');
    renderQuestion();
  }).fail(function () {
    Swal.fire({ title: 'Error', text: 'Gagal memuat soal!', icon: 'error', background: '#1a1a35', color: '#fff' });
  });
}

// ---- RENDER QUESTION ----
function renderQuestion() {
  var q = state.questions[state.currentIndex];
  var level = state.currentIndex + 1;

  state.answered = false;

  $('#currentQ').text(level);
  $('#qNumber').text(level);
  $('#questionText').text(q.question_text);
  $('#optA').text(q.option_a);
  $('#optB').text(q.option_b);
  $('#optC').text(q.option_c);
  $('#optD').text(q.option_d);

  // Reset options
  $('.option-btn').removeClass('selected correct wrong disabled hidden');

  // Difficulty badge
  var diff = q.difficulty;
  var diffLabel = diff === 'easy' ? 'Mudah' : diff === 'medium' ? 'Sedang' : 'Sulit';
  var diffColors = { easy: '#27ae60', medium: '#e67e22', hard: '#e74c3c' };
  $('#difficultyBadge')
    .text(diffLabel)
    .css({ background: diffColors[diff] + '22', color: diffColors[diff], border: '1px solid ' + diffColors[diff] + '66' });

  updatePrizeLadder(level);

  // Bind answer click
  $('.option-btn').off('click').on('click', function () {
    if (state.answered) return;
    var answer = $(this).data('answer');
    submitAnswer($(this), answer, q.id);
  });
}

// ---- SUBMIT ANSWER ----
function submitAnswer($el, answer, questionId) {
  state.answered = true;
  $el.addClass('selected');
  $('.option-btn').addClass('disabled');

  $.post('/play/check', { question_id: questionId, answer: answer }, function (res) {
    if (res.correct) {
      $el.removeClass('selected').addClass('correct');
      state.correctAnswers++;
      state.score += getScoreForLevel(state.currentIndex + 1);

      setTimeout(function () {
        state.currentIndex++;
        if (state.currentIndex < state.questions.length) {
          renderQuestion();
        } else {
          endGame(true);
        }
      }, 1200);
    } else {
      $el.removeClass('selected').addClass('wrong');
      // Show correct answer
      $('#opt-' + res.correct_answer).addClass('correct');

      setTimeout(function () {
        endGame(false);
      }, 1500);
    }
  });
}

// ---- SCORE PER LEVEL ----
function getScoreForLevel(level) {
  var scores = [100, 200, 400, 600, 800, 1000, 2000, 4000, 8000, 16000];
  return scores[level - 1] || 100;
}

// ---- 50:50 LIFELINE ----
function use5050() {
  var q = state.questions[state.currentIndex];
  state.lifelineUsed = true;
  $('#lifeline5050').prop('disabled', true).css('opacity', 0.3);

  // Get correct answer
  $.post('/play/check', { question_id: q.id, answer: 'X' }, function (res) {
    var correct = res.correct_answer;
    var allOpts = ['A', 'B', 'C', 'D'];
    var wrong = allOpts.filter(o => o !== correct);

    // Shuffle and pick 2 to hide
    wrong.sort(() => Math.random() - 0.5);
    var toHide = wrong.slice(0, 2);

    toHide.forEach(function (opt) {
      $('#opt-' + opt).addClass('hidden disabled');
    });

    Swal.fire({
      title: 'Lifeline 50:50',
      text: '2 jawaban salah telah dieliminasi!',
      icon: 'info',
      background: '#1a1a35',
      color: '#fff',
      timer: 1500,
      showConfirmButton: false
    });
  });
}

// ---- END GAME ----
function endGame(completed) {
  // Save score
  $.post('/scores/save', {
    participant_id: state.participantId,
    score: state.score,
    total_questions: state.questions.length,
    correct_answers: state.correctAnswers
  });

  // Show result screen
  var allCorrect = state.correctAnswers === state.questions.length;
  $('#resultIcon').text(allCorrect ? '🏆' : state.correctAnswers >= 7 ? '🎉' : state.correctAnswers >= 4 ? '👍' : '😢');
  $('#resultTitle').text(allCorrect ? 'SEMPURNA!' : completed ? 'Selesai!' : 'Salah!');
  $('#resultSubtitle').text(
    completed
      ? 'Kamu menyelesaikan semua soal!'
      : `Kamu terhenti di soal ke-${state.currentIndex + 1}`
  );
  $('#finalScore').text(state.score.toLocaleString('id-ID'));
  $('#statCorrect').text(state.correctAnswers);
  $('#statWrong').text(state.questions.length - state.correctAnswers);
  $('#statTotal').text(state.questions.length);

  setTimeout(function () {
    showScreen('screen-result');
  }, 500);
}

// ---- RESET STATE ----
function resetState() {
  state = {
    participantId: null,
    participantName: '',
    questions: [],
    currentIndex: 0,
    score: 0,
    correctAnswers: 0,
    lifelineUsed: false,
    answered: false
  };
}
